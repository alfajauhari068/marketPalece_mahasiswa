<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DashboardClientController extends Controller
{
    public function index()
    {
        $stats = [
            ['label' => 'Active Orders', 'value' => '6', 'icon' => 'bi-basket3', 'detail' => 'Orders in progress'],
            ['label' => 'Completed Orders', 'value' => '18', 'icon' => 'bi-check-circle', 'detail' => 'Delivered successfully'],
            ['label' => 'Total Spending', 'value' => 'Rp 4.320.000', 'icon' => 'bi-wallet2', 'detail' => 'Since last month'],
            ['label' => 'Average Rating', 'value' => '4.9', 'icon' => 'bi-star-fill', 'detail' => 'From clients'],
        ];

        $recentOrders = [
            ['id' => 1321, 'title' => 'Landing Page UI Design', 'seller' => 'Anisa Widya', 'status' => 'Diproses', 'date' => '2026-06-14', 'price' => 'Rp 850.000', 'badge' => 'warning'],
            ['id' => 1289, 'title' => 'SEO Article Package', 'seller' => 'Bayu Santoso', 'status' => 'Pending', 'date' => '2026-06-12', 'price' => 'Rp 220.000', 'badge' => 'secondary'],
            ['id' => 1274, 'title' => 'Brand Style Guide', 'seller' => 'Nadia Prasetyo', 'status' => 'Selesai', 'date' => '2026-06-08', 'price' => 'Rp 420.000', 'badge' => 'success'],
        ];

        $recommendedServices = [
            ['title' => 'Social Media Content', 'seller' => 'Putri', 'price' => 'Rp 260.000', 'category' => 'Marketing', 'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80'],
            ['title' => 'Web App Development', 'seller' => 'Riko', 'price' => 'Rp 720.000', 'category' => 'Programming', 'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=800&q=80'],
            ['title' => 'Presentation Design', 'seller' => 'Lina', 'price' => 'Rp 190.000', 'category' => 'Design', 'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80'],
        ];

        $recentActivities = [
            ['text' => 'Order #1321 moved to Diproses by Anisa.', 'time' => '2h ago'],
            ['text' => 'Payment for Order #1289 completed.', 'time' => '1d ago'],
            ['text' => 'New message from Bayu.', 'time' => '2d ago'],
        ];

        $quickActions = [
            ['label' => 'Create Order', 'icon' => 'bi-plus-circle', 'url' => '#'],
            ['label' => 'View Messages', 'icon' => 'bi-chat-dots', 'url' => route('dashboard.messages')],
            ['label' => 'Check Notifications', 'icon' => 'bi-bell', 'url' => route('dashboard.notifications')],
            ['label' => 'Edit Profile', 'icon' => 'bi-person-lines', 'url' => route('dashboard.profile.edit')],
        ];

        return view('klien.dashboard.index', compact('stats', 'recentOrders', 'recommendedServices', 'recentActivities', 'quickActions'))->with('active', 'dashboard');
    }

    public function orders()
    {
        $orders = [
            ['id' => 1321, 'title' => 'Landing Page UI Design', 'seller' => 'Anisa Widya', 'status' => 'Diproses', 'date' => '2026-06-14', 'price' => 'Rp 850.000', 'badge' => 'warning', 'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=640&q=80'],
            ['id' => 1289, 'title' => 'SEO Article Package', 'seller' => 'Bayu Santoso', 'status' => 'Pending', 'date' => '2026-06-12', 'price' => 'Rp 220.000', 'badge' => 'secondary', 'image' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=640&q=80'],
            ['id' => 1274, 'title' => 'Brand Style Guide', 'seller' => 'Nadia Prasetyo', 'status' => 'Selesai', 'date' => '2026-06-08', 'price' => 'Rp 420.000', 'badge' => 'success', 'image' => 'https://images.unsplash.com/photo-1499955085172-a104c9463ece?auto=format&fit=crop&w=640&q=80'],
            ['id' => 1248, 'title' => 'Copywriting Paket Produk', 'seller' => 'Dina', 'status' => 'Dibatalkan', 'date' => '2026-05-30', 'price' => 'Rp 170.000', 'badge' => 'danger', 'image' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=640&q=80'],
        ];

        return view('klien.dashboard.orders', compact('orders'))->with('active', 'orders');
    }

    public function orderDetail($id)
    {
        $order = [
            'id' => $id,
            'title' => 'Landing Page UI Design',
            'seller' => 'Anisa Widya',
            'status' => 'Diproses',
            'date' => '2026-06-14',
            'price' => 'Rp 850.000',
            'progress' => ['Payment received', 'Design draft shared', 'Feedback received'],
            'payment' => ['method' => 'Virtual Account', 'amount' => 'Rp 850.000', 'status' => 'Paid'],
            'summary' => ['Service fee' => 'Rp 20.000', 'Order total' => 'Rp 850.000', 'Delivery due' => '2026-06-20'],
            'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=820&q=80',
        ];

        return view('klien.dashboard.order-detail', compact('order'))->with('active', 'orders');
    }

    public function messages()
    {
        $chats = [
            ['id' => 1, 'name' => 'Anisa Widya', 'preview' => 'Saya sudah mengirim revisi, silakan cek.', 'time' => '1h ago', 'unread' => true],
            ['id' => 2, 'name' => 'Bayu Santoso', 'preview' => 'Terima kasih, pesanan sudah saya terima.', 'time' => 'yesterday', 'unread' => false],
            ['id' => 3, 'name' => 'Nadia Prasetyo', 'preview' => 'Bisa tambahkan referensi brand?', 'time' => '2d ago', 'unread' => false],
        ];

        return view('klien.dashboard.messages', compact('chats'))->with('active', 'messages');
    }

    public function messageDetail($id)
    {
        $chats = [
            ['id' => 1, 'name' => 'Anisa Widya', 'preview' => 'Saya sudah mengirim revisi, silakan cek.', 'time' => '1h ago', 'unread' => true],
            ['id' => 2, 'name' => 'Bayu Santoso', 'preview' => 'Terima kasih, pesanan sudah saya terima.', 'time' => 'yesterday', 'unread' => false],
            ['id' => 3, 'name' => 'Nadia Prasetyo', 'preview' => 'Bisa tambahkan referensi brand?', 'time' => '2d ago', 'unread' => false],
        ];

        $chat = ['id' => $id, 'name' => 'Anisa Widya', 'status' => 'Online', 'messages' => [
            ['author' => 'seller', 'text' => 'Halo, desain landing page sudah dalam progress. Saya kirimkan draft sore ini.', 'time' => '10:05'],
            ['author' => 'client', 'text' => 'Terima kasih! Saya ingin menu CTA lebih menonjol.', 'time' => '10:12'],
            ['author' => 'seller', 'text' => 'Baik, saya akan revisi sesuai arahan.', 'time' => '10:15'],
        ]];

        return view('klien.dashboard.message-detail', compact('chat', 'chats'))->with('active', 'messages');
    }

    public function notifications()
    {
        $notifications = [
            ['title' => 'Order #1321 berhasil dibayar', 'time' => '30m ago', 'unread' => true],
            ['title' => 'Pesan baru dari Bayu Santoso', 'time' => '2h ago', 'unread' => true],
            ['title' => 'Order #1274 selesai dan siap review', 'time' => '1d ago', 'unread' => false],
        ];

        return view('klien.dashboard.notifications', compact('notifications'))->with('active', 'notifications');
    }

    public function profile()
    {
        $user = Auth::user();
        $profileModel = $user->profile;

        $profile = [
            'name' => $user->name,
            'email' => $user->email,
            'bio' => $profileModel->bio ?? 'Profil Anda belum memiliki bio.',
            'photo' => $profileModel->photo ?? null,
            'rating_avg' => $profileModel->rating_avg ?? 0,
            'stats' => [
                'Orders' => '24',
                'Spent' => 'Rp 7.125.000',
                'Rating' => number_format($profileModel->rating_avg ?? 0, 1),
            ],
            'skills' => $profileModel->skills ?? [],
        ];

        return view('klien.dashboard.profile', compact('profile'))->with('active', 'profile');
    }

    public function profileEdit()
    {
        $user = Auth::user();
        $profileModel = $user->profile;

        $profile = [
            'name' => $user->name,
            'email' => $user->email,
            'bio' => $profileModel->bio ?? '',
            'skills' => $profileModel->skills ?? [],
            'photo' => $profileModel->photo ?? null,
            'rating_avg' => $profileModel->rating_avg ?? 0,
        ];

        return view('klien.dashboard.profile-edit', compact('profile'))->with('active', 'profile');
    }

    public function profileUpdate(\Illuminate\Http\Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (! $user) {
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

        // Update basic user info
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        // Update or create profile
        $profile = $user->profile()->firstOrNew(['user_id' => $user->id]);
        $profile->bio = $data['bio'] ?? $profile->bio;

        // Convert comma-separated skills string to array
        if (! empty($data['skills'])) {
            $skills = array_filter(array_map('trim', explode(',', $data['skills'])));
            $profile->skills = array_values($skills);
        } else {
            $profile->skills = [];
        }

        $profile->rating_avg = $data['rating_avg'] ?? $profile->rating_avg;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = Str::random(12) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_photos', $filename, 'public');
            $profile->photo = $path;
        }

        $profile->save();

        return redirect()->route('dashboard.profile')->with('status', 'Profil berhasil diperbarui.');
    }
}
