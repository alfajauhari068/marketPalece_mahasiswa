<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Order;

class OrderStatusTransition implements Rule
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function passes($attribute, $value): bool
    {
        $currentStatus = $this->order->status;
        $newStatus = $value;

        $transitions = [
            'pending' => ['diproses', 'dibatalkan'],
            'diproses' => ['selesai'],
        ];

        if (!isset($transitions[$currentStatus])) {
            return false;
        }

        return in_array($newStatus, $transitions[$currentStatus]);
    }

    public function message(): string
    {
        return 'Transisi status order tidak valid.';
    }
}
