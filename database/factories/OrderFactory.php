<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Service;
use App\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'buyer_id' => User::factory(),
            'seller_id' => User::factory(),
            'service_id' => Service::factory(),
            'status' => 'pending',
            'total_price' => $this->faker->randomFloat(2, 10000, 1000000),
        ];
    }
}
