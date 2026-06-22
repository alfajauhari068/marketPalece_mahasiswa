<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerEarningController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $total = Order::where('seller_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_price');

        $monthly = Order::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('SUM(total_price) as total'))
            ->where('seller_id', $user->id)
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        $payments = Payment::whereHas('order', function ($q) use ($user) {
            $q->where('seller_id', $user->id);
        })->latest()->paginate(12);

        return view('seller.earnings.index', compact('total', 'monthly', 'payments'))
            ->with('active', 'earnings');
    }
}
