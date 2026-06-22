<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalRevenue = Order::where('seller_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_price');

        $activeOrders = Order::where('seller_id', $user->id)
            ->where('status', '!=', 'completed')
            ->count();

        $totalServices = Service::where('user_id', $user->id)->count();

        $averageRating = Review::whereHas('order', function ($q) use ($user) {
            $q->where('seller_id', $user->id);
        })->avg('rating') ?: 0;

        $recentOrders = Order::with(['buyer', 'service.images'])
            ->where('seller_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $recentReviews = Review::with('reviewer', 'order')
            ->whereHas('order', function ($q) use ($user) {
                $q->where('seller_id', $user->id);
            })->latest()->limit(5)->get();

        return view('seller.dashboard.index', compact(
            'totalRevenue', 'activeOrders', 'totalServices', 'averageRating', 'recentOrders', 'recentReviews'
        ))->with('active', 'dashboard');
    }

    public function profile()
    {
        $user = auth()->user();
        $serviceCount = Service::where('user_id', $user->id)->count();

        return view('seller.dashboard.profile', compact('user', 'serviceCount'))
            ->with('active', 'profile');
    }

    public function settings()
    {
        return view('seller.dashboard.settings')
            ->with('active', 'settings');
    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $user = auth()->user();
        if (!$user) {
            abort(403);
        }

        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = now()->timestamp . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile', $filename, 'public');

            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }

            $profile->photo = $path;
            $profile->save();
        }

        return redirect()->route('seller.profile')->with('success', 'Foto profil berhasil diunggah.');
    }
}
