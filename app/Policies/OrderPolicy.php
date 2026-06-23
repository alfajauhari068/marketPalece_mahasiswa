<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view the order.
     * 
     * Buyer can view their own orders.
     * Seller can view orders they're involved in.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id || $user->id === $order->seller_id;
    }

    /**
     * Determine whether the user can create orders.
     * 
     * Only buyers can create orders.
     */
    public function create(User $user): bool
    {
        return $user->isBuyer();
    }

    /**
     * Determine whether the user can update the order.
     * 
     * Only the buyer can update their order before payment.
     * Sellers can update order status (via business logic, not policy).
     */
    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id && $order->status === 'pending';
    }

    /**
     * Determine whether the user can cancel the order.
     * 
     * Buyer can cancel pending orders.
     */
    public function cancel(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id && $order->status === 'pending';
    }
}
