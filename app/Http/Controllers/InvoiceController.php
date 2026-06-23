<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Show invoice page
     * 
     * Display:
     * - Invoice number
     * - Order ID
     * - Service information
     * - Seller information
     * - Client information
     * - Quantity
     * - Notes
     * - Payment method
     * - Payment status
     * - Transaction date
     * - Total price
     * - Download PDF button
     */
    public function show(Order $order)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Ensure user is the buyer or seller
        if ($order->buyer_id !== $user->id && $order->seller_id !== $user->id) {
            abort(403, 'You cannot access this invoice');
        }

        // Load relationships
        $order->load(['service', 'buyer', 'seller', 'orderDetail', 'payment']);

        return view('klien.invoice.show', compact('order'));
    }

    /**
     * Download invoice as PDF
     * 
     * Generate PDF with invoice details and download
     * 
     * Requirements:
     * - dompdf or similar PDF library
     * - Invoice layout with all details
     */
    public function download(Order $order)
    {
        // Ensure user is authenticated
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Ensure user is the buyer or seller
        if ($order->buyer_id !== $user->id && $order->seller_id !== $user->id) {
            abort(403, 'You cannot download this invoice');
        }

        // Load relationships
        $order->load(['service', 'buyer', 'seller', 'orderDetail', 'payment']);

        // Generate PDF
        $pdf = \PDF::loadView('klien.invoice.pdf', compact('order'));

        // Download with filename: Invoice-{order_code}.pdf
        return $pdf->download('Invoice-' . $order->order_code . '.pdf');
    }
}
