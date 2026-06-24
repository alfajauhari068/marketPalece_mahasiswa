<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create a review for given order.
     */
    public function create(User $user, Order $order): bool
    {
        // Only buyers can create, must own the order, and order must be completed
        if (! $user->isBuyer()) {
            return false;
        }

        if ($order->buyer_id !== $user->id) {
            return false;
        }

        if ($order->status !== 'selesai') {
            return false;
        }

        // Prevent seller reviewing own service
        if ($order->seller_id === $user->id) {
            return false;
        }

        // Prevent duplicate review
        return ! $order->review()->exists();
    }

    /**
     * Determine whether the user can view the review.
     */
    public function view(User $user, Review $review): bool
    {
        if ($user->id === $review->reviewer_id) {
            return true;
        }

        if ($user->isSeller() && $review->seller_id === $user->id) {
            return true;
        }

        return $user->isAdmin();
    }
}
