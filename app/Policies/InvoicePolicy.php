<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class InvoicePolicy
{
    /**
     * Determine whether the user can view the invoice.
     * 
     * Both buyer and seller of the related order can view the invoice.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id || $user->id === $order->seller_id;
    }

    /**
     * Determine whether the user can download the invoice.
     * 
     * Both buyer and seller can download the invoice.
     */
    public function download(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id || $user->id === $order->seller_id;
    }
}
