<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class SellerReviewController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $reviews = Review::whereHas('order', function ($q) use ($user) {
            $q->where('seller_id', $user->id);
        })->with('reviewer', 'order')->latest()->paginate(12);

        return view('seller.reviews.index', compact('reviews'))
            ->with('active', 'reviews');
    }
}
