<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Service;
use App\Models\User;

class PreventSelfPurchase implements Rule
{
    public function passes($attribute, $value): bool
    {
        $service = Service::find($value);
        if (!$service) {
            return false;
        }

        $buyerId = request()->user()->id;
        $sellerId = $service->user_id;

        return $buyerId !== $sellerId;
    }

    public function message(): string
    {
        return 'Anda tidak dapat membeli jasa Anda sendiri.';
    }
}
