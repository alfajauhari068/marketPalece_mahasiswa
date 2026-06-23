<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Determine whether the user can view the payment.
     * 
     * Only the buyer and seller of the related order can view the payment.
     */
    public function view(User $user, Payment $payment): bool
    {
        $order = $payment->order;
        return $user->id === $order->buyer_id || $user->id === $order->seller_id;
    }

    /**
     * Determine whether the user can create a payment.
     * 
     * Only the buyer of the related order can create a payment.
     */
    public function create(User $user): bool
    {
        return $user->isBuyer();
    }

    /**
     * Determine whether the user can process payment.
     * 
     * Only the buyer can process payment for their own order.
     */
    public function process(User $user, Payment $payment): bool
    {
        $order = $payment->order;
        return $user->id === $order->buyer_id;
    }

    /**
     * Sellers cannot modify payments.
     */
    public function modify(User $user, Payment $payment): bool
    {
        return false;
    }
}
