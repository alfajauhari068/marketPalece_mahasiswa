<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Show payment page for an order
     * 
     * Display:
     * - Order summary
     * - Payment amount
     * - Payment method options (QRIS, Bank Transfer, E-wallet)
     */
    public function show(Order $order)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Ensure user is the buyer
        if ($order->buyer_id !== $user->id) {
            abort(403, 'You cannot access this order');
        }

        // Load relationships
        $order->load(['service', 'buyer', 'seller', 'orderDetail', 'payment']);

        return view('klien.payment.show', compact('order'));
    }

    /**
     * Process payment
     * 
     * Flow:
     * - Validate payment method
     * - Create Payment record
     * - Generate transaction_id
     * - Simulate payment processing (for demo)
     * - Redirect to success/failed page
     * 
     * In production: integrate with payment gateway
     */
    public function process(Request $request, Order $order)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Ensure user is the buyer
        if ($order->buyer_id !== $user->id) {
            abort(403, 'You cannot pay for this order');
        }

        // Validate input
        $validated = $request->validate([
            'payment_method' => 'required|in:qris,bank_transfer,e_wallet',
        ]);

        try {
            // Check if payment already exists
            if ($order->payment) {
                return redirect()->route('payment.show', $order->id)
                    ->with('warning', 'Payment already exists for this order');
            }

            // Generate unique transaction_id
            $transactionId = 'TXN-' . strtoupper(Str::random(16));

            // Create payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $transactionId,
                'method' => $validated['payment_method'],
                'amount' => $order->total_price,
                'status' => 'pending',
            ]);

            // In production: Send to payment gateway (QRIS provider, Bank API, etc.)
            // For now: Simulate immediate success for demo
            // In real implementation, payment gateway would call webhook with status

            // Simulate payment success (remove this in production)
            if ($request->input('_simulate_success') === 'true') {
                return $this->markPaymentSuccess($order, $payment);
            }

            // Simulate payment failure (remove this in production)
            if ($request->input('_simulate_failure') === 'true') {
                return $this->markPaymentFailed($order, $payment);
            }

            // In real implementation, redirect to payment gateway
            return redirect()->route('payment.success', $order->id);

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Payment processing failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Payment success page
     * 
     * Display:
     * - Success icon
     * - Success message
     * - Transaction number
     * - Order summary
     * - Buttons: View Invoice, Go to Dashboard
     */
    public function success(Order $order)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Ensure user is the buyer
        if ($order->buyer_id !== $user->id) {
            abort(403, 'You cannot access this order');
        }

        // Load relationships
        $order->load(['service', 'buyer', 'seller', 'payment']);

        // Verify payment is completed
        if (!$order->payment || $order->payment->status !== 'paid') {
            return redirect()->route('payment.show', $order->id)
                ->with('warning', 'Payment not yet completed');
        }

        return view('klien.payment.success', compact('order'));
    }

    /**
     * Payment failed page
     * 
     * Display:
     * - Failure icon
     * - Failure message
     * - Retry Payment button
     * - Back to Checkout button
     */
    public function failed(Order $order)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Ensure user is the buyer
        if ($order->buyer_id !== $user->id) {
            abort(403, 'You cannot access this order');
        }

        // Load relationships
        $order->load(['service', 'payment']);

        return view('klien.payment.failed', compact('order'));
    }

    /**
     * Mark payment as successful
     * Update order status: pending → paid
     */
    private function markPaymentSuccess(Order $order, Payment $payment)
    {
        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $order->update([
            'status' => 'diproses', // Mark as processed/in progress
        ]);

        return redirect()->route('payment.success', $order->id)
            ->with('success', 'Payment completed successfully!');
    }

    /**
     * Mark payment as failed
     * Keep order status: pending
     */
    private function markPaymentFailed(Order $order, Payment $payment)
    {
        $payment->update([
            'status' => 'failed',
        ]);

        return redirect()->route('payment.failed', $order->id)
            ->with('error', 'Payment failed. Please try again.');
    }
}
