<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show checkout form
     */
    public function create(Service $service)
    {
        $service->load(['user', 'category', 'images']);

        if ($service->status !== 'live') {
            abort(404);
        }

        return view('klien.checkout.create', compact('service'));
    }

    /**
     * Store order from checkout
     * 
     * Flow:
     * - Validate buyer role
     * - Validate quantity
     * - Prevent seller from buying own service
     * - Create Order record
     * - Create OrderDetail record (notes)
     * - Redirect to payment page
     */
    public function store(Request $request, Service $service)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Ensure user is buyer
        if (!$user->isBuyer()) {
            abort(403, 'Only buyers can place orders');
        }

        // Prevent seller from buying own service
        if ($service->user_id === $user->id) {
            abort(403, 'You cannot purchase your own service');
        }

        // Ensure service is live
        if ($service->status !== 'live') {
            abort(404, 'Service not available');
        }

        // Validate input
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calculate total price
        $quantity = $validated['quantity'];
        $subtotal = $service->price * $quantity;
        $totalPrice = $subtotal; // Without additional fees for now

        try {
            // Create order
            $order = Order::create([
                'buyer_id' => $user->id,
                'seller_id' => $service->user_id,
                'service_id' => $service->id,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // Create order detail (notes)
            if (!empty($validated['notes'])) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'note' => $validated['notes'],
                ]);
            }

            // Redirect to payment page
            return redirect()->route('payment.show', $order->id)
                ->with('success', 'Order created successfully. Please complete payment.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to create order. Please try again.')
                ->withInput();
        }
    }
}
