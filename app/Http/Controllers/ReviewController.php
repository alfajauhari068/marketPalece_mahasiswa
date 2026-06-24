<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Order $order)
    {
        $this->authorize('create', [Review::class, $order]);

        $order->load('service', 'seller');

        return view('reviews.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $this->authorize('create', [Review::class, $order]);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'feedback' => 'nullable|string',
        ]);

        // Sanitize inputs to prevent XSS
        $data['comment'] = strip_tags($data['comment']);
        $data['feedback'] = isset($data['feedback']) ? strip_tags($data['feedback']) : null;

        $review = Review::create([
            'order_id' => $order->id,
            'service_id' => $order->service_id,
            'buyer_id' => $order->buyer_id,
            'seller_id' => $order->seller_id,
            'reviewer_id' => auth()->id(),
            'rating' => $data['rating'],
            'comment' => $data['comment'],
            'feedback' => $data['feedback'] ?? null,
        ]);

        return redirect()->route('review.show', $review->id)->with('success', 'Review submitted successfully.');
    }

    public function show(Review $review)
    {
        $this->authorize('view', $review);

        $review->load('reviewer.profile', 'service.images', 'seller.profile', 'order');

        return view('reviews.show', compact('review'));
    }
}
