<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class DashboardClientController extends Controller
{
    /**
     * Enable query logging for debugging
     */
    private function enableQueryLogging(): void
    {
        DB::enableQueryLog();
    }

    /**
     * Log executed queries with context and metadata
     */
    private function logQueries(string $context, array $extra = []): void
    {
        $queries = DB::getQueryLog();
        Log::debug("DashboardClientController::{$context} query log", array_merge([
            'query_count' => count($queries),
            'queries' => $queries,
        ], $extra));
        DB::disableQueryLog();
    }

    /**
     * Verify authenticated user and return or abort
     */
    private function getAuthenticatedUser()
    {
        $user = auth()->user();
        if (!$user) {
            Log::warning('Unauthorized access attempt to client dashboard');
            abort(403, 'Unauthorized access');
        }
        return $user;
    }

    /**
     * Format order data for view display
     */
    private function formatOrderForView(Order $order): array
    {
        return [
            'id' => $order->id,
            'title' => $order->service?->title ?? 'Order #' . $order->id,
            'seller' => $order->seller?->name ?? 'Unknown seller',
            'status' => $order->status,
            'date' => optional($order->created_at)->format('Y-m-d') ?? '',
            'price' => 'Rp ' . number_format($order->total_price ?? 0, 0, ',', '.'),
            'badge' => match ($order->status) {
                'pending' => 'secondary',
                'diproses' => 'warning',
                'selesai' => 'success',
                'dibatalkan' => 'danger',
                default => 'secondary',
            },
            'image' => $order->service?->primary_image ?? 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=640&q=80',
        ];
    }

    /**
     * Format service data for view display
     */
    private function formatServiceForView(Service $service): array
    {
        return [
            'id' => $service->id,
            'title' => $service->title,
            'seller' => $service->user?->name ?? 'Unknown seller',
            'price' => 'Rp ' . number_format($service->price ?? 0, 0, ',', '.'),
            'category' => $service->category?->name ?? 'Uncategorized',
            'primary_image' => $service->primary_image ?? 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80',
            'images' => $service->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->url,
                    'sort_order' => $image->sort_order,
                ];
            })->values()->toArray(),
        ];
    }

    /**
     * Generate recent activities from orders, chats, and payments
     */
    private function generateRecentActivities($user)
    {
        $activities = collect();

        // Recent orders
        $user->ordersAsBuyer()
            ->with('service')
            ->latest()
            ->limit(3)
            ->get()
            ->each(function (Order $order) use (&$activities) {
                $activities->push([
                    'text' => "Order for {$order->service?->title} placed",
                    'time' => optional($order->created_at)->diffForHumans() ?? 'recently',
                ]);
            });

        // Recent messages
        Chat::where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->limit(2)
            ->get()
            ->each(function (Chat $chat) use (&$activities, $user) {
                $other = $chat->sender_id === $user->id ? $chat->receiver?->name : $chat->sender?->name;
                $activities->push([
                    'text' => "Message from {$other}",
                    'time' => optional($chat->created_at)->diffForHumans() ?? 'recently',
                ]);
            });

        return $activities->sortByDesc('time')->take(5);
    }

    /**
     * Display client dashboard with statistics, recent orders, and recommended services
     */
    public function index(Request $request)
    {
        try {
            $this->enableQueryLogging();
            $user = $this->getAuthenticatedUser();
            $userId = auth()->id();
            $cacheKey = "dashboard_stats_{$userId}";

            Log::info('Dashboard index accessed', ['user_id' => $user->id, 'cache_key' => $cacheKey]);

            // Model counts for debugging
            Log::debug('Database model counts', [
                'users' => User::count(),
                'profiles' => Profile::count(),
                'services' => Service::count(),
                'orders' => Order::count(),
                'reviews' => Review::count(),
                'payments' => Payment::count(),
                'chats' => Chat::count(),
            ]);

            // Statistics: Active and completed orders (cached for 10 minutes)
            $stats = Cache::remember($cacheKey, 600, function () use ($userId, $user) {
                $activeOrders = Order::where('buyer_id', $userId)
                    ->whereIn('status', ['pending', 'diproses'])
                    ->count();

                $completedOrders = Order::where('buyer_id', $userId)
                    ->where('status', 'selesai')
                    ->count();

                // Total spending: sum completed orders' total_price
                $totalSpending = Order::where('buyer_id', $userId)
                    ->where('status', 'selesai')
                    ->sum('total_price')
                    ?? 0;

                // Average rating from the authenticated user's profile
                $averageRating = $user->profile?->rating_avg ?? 0;

                return collect([
                    ['label' => 'Active Orders', 'value' => $activeOrders, 'icon' => 'bi-basket3', 'detail' => 'Orders in progress'],
                    ['label' => 'Completed Orders', 'value' => $completedOrders, 'icon' => 'bi-check-circle', 'detail' => 'Delivered successfully'],
                    ['label' => 'Total Spending', 'value' => 'Rp ' . number_format($totalSpending, 0, ',', '.'), 'icon' => 'bi-wallet2', 'detail' => 'Since last month'],
                    ['label' => 'Average Rating', 'value' => number_format($averageRating, 1), 'icon' => 'bi-star-fill', 'detail' => 'From reviews'],
                ]);
            });

            // Recent orders with search support
            $recentOrdersQuery = Order::with(['service.images', 'seller', 'buyer'])
                ->where('buyer_id', $userId)
                ->latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $recentOrdersQuery->whereHas('service', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            }

            $recentOrders = $recentOrdersQuery
                ->limit(5)
                ->get()
                ->map(fn(Order $order) => $this->formatOrderForView($order));

            // Recommended services (live services, excluding user's own)
            $servicesQuery = Service::with(['user', 'category', 'images'])
                ->where('status', 'live')
                ->where('user_id', '!=', $userId)
                ->latest();

            if ($request->filled('search')) {
                $search = $request->search;
                $servicesQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }

            $recommendedServices = $servicesQuery
                ->paginate(12)
                ->withQueryString()
                ->through(fn(Service $service) => $this->formatServiceForView($service));

            // Recent activities (generated from orders and chats)
            $recentActivities = $this->generateRecentActivities($user);

            // Quick actions
            $quickActions = collect([
                ['label' => 'View Messages', 'icon' => 'bi-chat-dots', 'url' => route('dashboard.messages')],
                ['label' => 'Check Notifications', 'icon' => 'bi-bell', 'url' => route('dashboard.notifications')],
                ['label' => 'Edit Profile', 'icon' => 'bi-person-lines', 'url' => route('dashboard.profile.edit')],
            ]);

            $this->logQueries('index', [
                'user_id' => $user->id,
                'stats_count' => $stats->count(),
                'recent_orders_count' => $recentOrders->count(),
                'recommended_services_count' => $recommendedServices->total(),
            ]);

            return view('klien.dashboard.index', compact(
                'stats',
                'recentOrders',
                'recommendedServices',
                'recentActivities',
                'quickActions'
            ))->with('active', 'dashboard');
        } catch (\Exception $e) {
            Log::error('Dashboard index error', [
                'user_id' => $user->id ?? null,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Failed to load dashboard');
        }
    }

    /**
     * Display user's orders with search and pagination
     */
    public function orders(Request $request)
    {
        try {
            $this->enableQueryLogging();
            $user = $this->getAuthenticatedUser();

            $query = $user->ordersAsBuyer()
                ->with(['service', 'seller'])
                ->latest();

            // Search: service title or seller name
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('service', function ($qq) use ($search) {
                        $qq->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('seller', function ($qq) use ($search) {
                        $qq->where('name', 'like', "%{$search}%");
                    });
                });
            }

            $paginator = $query->paginate(10)->withQueryString();
            $collection = $paginator->getCollection()->map(fn(Order $order) => $this->formatOrderForView($order));
            $paginator->setCollection($collection);

            $this->logQueries('orders', [
                'user_id' => $user->id,
                'orders_count' => $paginator->total(),
            ]);

            return view('klien.dashboard.orders', ['orders' => $paginator])->with('active', 'orders');
        } catch (\Exception $e) {
            Log::error('Orders page error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load orders');
        }
    }

    /**
     * Search across services, orders, and messages with JSON response
     */
    public function search(Request $request)
    {
        try {
            $userId = auth()->id();
            $query = $request->query('q', '');
            $type = $request->query('type', 'all'); // all, services, orders, messages
            $page = $request->query('page', 1);

            // Validate search input
            $validated = $request->validate([
                'q' => 'nullable|string|max:255',
                'type' => 'nullable|in:all,services,orders,messages',
                'page' => 'nullable|integer|min:1',
            ]);

            // Reject empty search queries
            if (empty(trim($query))) {
                Log::warning('Empty search query', ['user_id' => $userId, 'type' => $type]);
                return response()->json([
                    'success' => false,
                    'message' => 'Search query cannot be empty',
                ], 400);
            }

            Log::info('Dashboard search initiated', ['user_id' => $userId, 'query' => $query, 'type' => $type, 'page' => $page]);

            $results = [];

            // Search services
            if ($type === 'all' || $type === 'services') {
                $services = Service::with(['user', 'category', 'images'])
                    ->where('status', 'live')
                    ->where('user_id', '!=', $userId)
                    ->where(function ($q) use ($query) {
                        $q->where('title', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->paginate(5, ['*'], 'services_page');

                $results['services'] = [
                    'data' => $services->getCollection()->map(fn(Service $s) => $this->formatServiceForView($s))->toArray(),
                    'total' => $services->total(),
                    'page' => $services->currentPage(),
                    'per_page' => $services->perPage(),
                    'last_page' => $services->lastPage(),
                ];
            }

            // Search orders
            if ($type === 'all' || $type === 'orders') {
                $orders = Order::with(['service.images', 'seller'])
                    ->where('buyer_id', $userId)
                    ->where(function ($q) use ($query) {
                        $q->whereHas('service', function ($qq) use ($query) {
                            $qq->where('title', 'like', "%{$query}%");
                        })
                        ->orWhereHas('seller', function ($qq) use ($query) {
                            $qq->where('name', 'like', "%{$query}%");
                        });
                    })
                    ->latest()
                    ->paginate(5, ['*'], 'orders_page');

                $results['orders'] = [
                    'data' => $orders->getCollection()->map(fn(Order $o) => $this->formatOrderForView($o))->toArray(),
                    'total' => $orders->total(),
                    'page' => $orders->currentPage(),
                    'per_page' => $orders->perPage(),
                    'last_page' => $orders->lastPage(),
                ];
            }

            // Search messages
            if ($type === 'all' || $type === 'messages') {
                $chats = Chat::with(['sender', 'receiver'])
                    ->where(function ($q) use ($userId) {
                        $q->where('sender_id', $userId)->orWhere('receiver_id', $userId);
                    })
                    ->where('message', 'like', "%{$query}%")
                    ->latest()
                    ->paginate(5, ['*'], 'messages_page');

                $results['messages'] = [
                    'data' => $chats->getCollection()->map(function (Chat $c) use ($userId) {
                        $other = $c->sender_id === $userId ? $c->receiver : $c->sender;
                        return [
                            'id' => $c->id,
                            'name' => $other?->name ?? 'Unknown',
                            'message' => Str::limit($c->message, 50),
                            'time' => optional($c->created_at)->diffForHumans() ?? '',
                        ];
                    })->toArray(),
                    'total' => $chats->total(),
                    'page' => $chats->currentPage(),
                    'per_page' => $chats->perPage(),
                    'last_page' => $chats->lastPage(),
                ];
            }

            // Log search completion with result counts
            $resultCounts = collect($results)->map(fn($r) => $r['total'] ?? 0)->all();
            Log::info('Dashboard search completed', [
                'user_id' => $userId,
                'query' => $query,
                'type' => $type,
                'result_counts' => $resultCounts,
            ]);

            return response()->json([
                'success' => true,
                'query' => $query,
                'type' => $type,
                'results' => $results,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Search error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display single order detail
     */
    public function orderDetail($id)
    {
        try {
            $this->enableQueryLogging();
            $user = $this->getAuthenticatedUser();
            $userId = auth()->id();

            $order = Order::with(['service', 'seller', 'payment'])
                ->where('buyer_id', $userId)
                ->findOrFail($id);

                $orderData = [
                'id' => $order->id,
                'title' => $order->service?->title ?? 'Order #' . $order->id,
                'seller' => $order->seller?->name ?? 'Unknown seller',
                'status' => $order->status,
                'date' => optional($order->created_at)->format('Y-m-d') ?? '',
                'price' => 'Rp ' . number_format($order->total_price ?? 0, 0, ',', '.'),
                'progress' => [],
                'payment' => [
                    'method' => $order->payment?->method ?? 'Unknown',
                    'amount' => 'Rp ' . number_format($order->total_price ?? 0, 0, ',', '.'),
                    'status' => $order->payment?->status ?? 'Unknown',
                ],
                'summary' => [
                    'Order total' => 'Rp ' . number_format($order->total_price ?? 0, 0, ',', '.'),
                    'Payment status' => $order->payment?->status ?? 'Unknown',
                ],
                'image' => $order->service?->primary_image ?? 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=820&q=80',
            ];

            $this->logQueries('orderDetail', ['user_id' => $user->id, 'order_id' => $order->id]);

            return view('klien.dashboard.order-detail', ['order' => $orderData])->with('active', 'orders');
        } catch (\Exception $e) {
            // If not found, return 404 to match expected API behavior
            if ($e instanceof ModelNotFoundException) {
                abort(404);
            }
            Log::error('Order detail error', ['message' => $e->getMessage()]);
            return redirect()->route('dashboard.orders')->with('error', 'Order not found');
        }
    }

    /**
     * Display chat messages with search and pagination
     */
    public function messages(Request $request)
    {
        try {
            $this->enableQueryLogging();
            $user = $this->getAuthenticatedUser();

            $query = Chat::with(['sender', 'receiver'])
                ->where(function ($q) use ($user) {
                    $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })
                ->latest();

            // Search: message content or sender/receiver name
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('message', 'like', "%{$search}%")
                        ->orWhereHas('sender', fn($qq) => $qq->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('receiver', fn($qq) => $qq->where('name', 'like', "%{$search}%"));
                });
            }

            $paginator = $query->paginate(10)->withQueryString();
            $collection = $paginator->getCollection()->map(function (Chat $chat) use ($user) {
                $other = $chat->sender_id === $user->id ? $chat->receiver : $chat->sender;
                return [
                    'id' => $chat->id,
                    'name' => $other?->name ?? 'Unknown',
                    'preview' => Str::limit($chat->message, 40),
                    'time' => optional($chat->created_at)->diffForHumans() ?? '',
                    'unread' => ! $chat->is_read && $chat->receiver_id === $user->id,
                ];
            });
            $paginator->setCollection($collection);

            $this->logQueries('messages', ['user_id' => $user->id, 'chats_count' => $paginator->total()]);

            return view('klien.dashboard.messages', ['chats' => $paginator])->with('active', 'messages');
        } catch (\Exception $e) {
            Log::error('Messages page error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load messages');
        }
    }

    /**
     * Display detailed conversation with single user
     */
    public function messageDetail($id)
    {
        try {
            $this->enableQueryLogging();
            $user = $this->getAuthenticatedUser();

            $selectedChat = Chat::with(['sender', 'receiver'])
                ->where(function ($query) use ($user) {
                    $query->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
                })
                ->findOrFail($id);

            $otherUserId = $selectedChat->sender_id === $user->id
                ? $selectedChat->receiver_id
                : $selectedChat->sender_id;

            // Get all messages in conversation
            $chats = Chat::with(['sender', 'receiver'])
                ->where(function ($query) use ($user, $otherUserId) {
                    $query->where('sender_id', $user->id)->where('receiver_id', $otherUserId);
                })
                ->orWhere(function ($query) use ($user, $otherUserId) {
                    $query->where('sender_id', $otherUserId)->where('receiver_id', $user->id);
                })
                ->latest()
                ->get()
                ->map(function (Chat $chat) use ($user) {
                    $other = $chat->sender_id === $user->id ? $chat->receiver : $chat->sender;
                    return [
                        'id' => $chat->id,
                        'name' => $other?->name ?? 'Unknown',
                        'preview' => Str::limit($chat->message, 40),
                        'time' => optional($chat->created_at)->diffForHumans() ?? '',
                        'unread' => ! $chat->is_read && $chat->receiver_id === $user->id,
                    ];
                });

            // Get all messages for conversation display
            $messages = Chat::with(['sender', 'receiver'])
                ->where(function ($query) use ($user, $otherUserId) {
                    $query->where('sender_id', $user->id)->where('receiver_id', $otherUserId);
                })
                ->orWhere(function ($query) use ($user, $otherUserId) {
                    $query->where('sender_id', $otherUserId)->where('receiver_id', $user->id);
                })
                ->oldest()
                ->get()
                ->map(function (Chat $message) use ($user) {
                    return [
                        'author' => $message->sender_id === $user->id ? 'client' : 'seller',
                        'text' => $message->message,
                        'time' => optional($message->created_at)->format('H:i'),
                    ];
                });

            $chat = [
                'id' => $selectedChat->id,
                'name' => $selectedChat->sender_id === $user->id ? $selectedChat->receiver?->name : $selectedChat->sender?->name,
                'status' => 'Online',
                'messages' => $messages,
            ];

            $this->logQueries('messageDetail', [
                'user_id' => $user->id,
                'chat_id' => $selectedChat->id,
                'messages_count' => $messages->count(),
            ]);

            return view('klien.dashboard.message-detail', compact('chat', 'chats'))->with('active', 'messages');
        } catch (\Exception $e) {
            Log::error('Message detail error', ['message' => $e->getMessage()]);
            return redirect()->route('dashboard.messages')->with('error', 'Conversation not found');
        }
    }

    /**
     * Display user notifications
     */
    public function notifications()
    {
        try {
            $this->enableQueryLogging();
            $user = $this->getAuthenticatedUser();

            // Fall back to empty collection if notifications table doesn't exist
            $notifications = collect();
            try {
                $notifications = $user->notifications()
                    ->latest()
                    ->limit(10)
                    ->get()
                    ->map(function ($notification) {
                        return [
                            'title' => $notification->data['title'] ?? class_basename($notification->type),
                            'time' => optional($notification->created_at)->diffForHumans() ?? '',
                            'unread' => is_null($notification->read_at),
                        ];
                    });
            } catch (\Exception $e) {
                Log::warning('Notifications table access failed', ['message' => $e->getMessage()]);
            }

            $this->logQueries('notifications', [
                'user_id' => $user->id,
                'notifications_count' => $notifications->count(),
            ]);

            return view('klien.dashboard.notifications', compact('notifications'))->with('active', 'notifications');
        } catch (\Exception $e) {
            Log::error('Notifications page error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load notifications');
        }
    }

    /**
     * Display user profile
     */
    public function profile()
    {
        try {
            $this->enableQueryLogging();
            $user = Auth::user();
            if (!$user) {
                abort(403);
            }

            $profileModel = $user->profile;
            $completedOrders = $user->ordersAsBuyer()->where('status', 'selesai')->count();
            $totalSpending = Order::where('buyer_id', $user->id)
                ->where('status', 'selesai')
                ->sum('total_price')
                ?? 0;

            $profile = [
                'name' => $user->name,
                'email' => $user->email,
                'bio' => $profileModel?->bio ?? 'Profil Anda belum memiliki bio.',
                'photo' => $profileModel?->photo ?? null,
                'rating_avg' => $profileModel?->rating_avg ?? 0,
                'stats' => [
                    'Orders' => $completedOrders,
                    'Spent' => 'Rp ' . number_format($totalSpending, 0, ',', '.'),
                    'Rating' => number_format($profileModel?->rating_avg ?? 0, 1),
                ],
                'skills' => $profileModel?->skills ?? [],
            ];

            $this->logQueries('profile', ['user_id' => $user->id, 'completed_orders' => $completedOrders]);

            return view('klien.dashboard.profile', compact('profile'))->with('active', 'profile');
        } catch (\Exception $e) {
            Log::error('Profile page error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load profile');
        }
    }

    /**
     * Show profile edit form
     */
    public function profileEdit()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                abort(403);
            }

            $profileModel = $user->profile;
            $profile = [
                'name' => $user->name,
                'email' => $user->email,
                'bio' => $profileModel?->bio ?? '',
                'skills' => $profileModel?->skills ?? [],
                'photo' => $profileModel?->photo ?? null,
                'rating_avg' => $profileModel?->rating_avg ?? 0,
            ];

            return view('klien.dashboard.profile-edit', compact('profile'))->with('active', 'profile');
        } catch (\Exception $e) {
            Log::error('Profile edit form error', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load edit form');
        }
    }

    /**
     * Update user profile
     */
    public function profileUpdate(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->withErrors(['message' => 'Anda harus login untuk mengedit profil.']);
            }

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'bio' => 'nullable|string|max:2000',
                'skills' => 'nullable|string',
                'rating_avg' => 'nullable|numeric|min:0|max:5',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            ]);

            // Update user
            $user->update(['name' => $data['name'], 'email' => $data['email']]);

            // Update or create profile
            $profile = $user->profile ?? new Profile(['user_id' => $user->id]);
            $profile->bio = $data['bio'] ?? $profile->bio;
            $profile->rating_avg = $data['rating_avg'] ?? $profile->rating_avg;

            if (!empty($data['skills'])) {
                $skills = array_filter(array_map('trim', explode(',', $data['skills'])));
                $profile->skills = array_values($skills);
            }

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = Str::random(12) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profile_photos', $filename, 'public');
                $profile->photo = $path;
            }

            $profile->save();

            Log::info('Profile updated', ['user_id' => $user->id]);

            return redirect()->route('dashboard.profile')->with('status', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Profile update error', ['user_id' => $user->id ?? null, 'message' => $e->getMessage()]);
            return redirect()->back()->withErrors(['error' => 'Failed to update profile']);
        }
    }
}
