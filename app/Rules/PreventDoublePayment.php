<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Order;

class PreventDoublePayment implements Rule
{
    public function passes($attribute, $value): bool
    {
        $order = Order::find($value);
        if (!$order) {
            return false;
        }

        return $order->payment === null || $order->payment->status !== 'paid';
    }

    public function message(): string
    {
        return 'Pembayaran untuk order ini sudah dilakukan.';
    }
}
