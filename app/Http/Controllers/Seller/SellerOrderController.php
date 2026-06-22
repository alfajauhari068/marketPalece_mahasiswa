<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = Order::with('buyer', 'service')->where('seller_id', $user->id)->latest()->paginate(12);

        return view('seller.orders.index', compact('orders'))
            ->with('active', 'orders');
    }

    public function show(Order $order)
    {
        if ($order->seller_id !== auth()->id()) {
            abort(403);
        }
        $order->load('buyer', 'service', 'payment', 'review');
        return view('seller.orders.show', compact('order'))
            ->with('active', 'orders');
    }
}
