<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Chat;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;use Illuminate\Support\Collection;use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientWorkspaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = Category::factory()->count(5)->create();

        // Create 10 buyer users (using 'mahasiswa' role from enum)
        $buyers = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "Buyer {$i}",
                'email' => "buyer{$i}@marketplace.test",
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
            ]);

            // Create profile for buyer
            Profile::create([
                'user_id' => $user->id,
                'bio' => "I'm a buyer looking for quality services",
                'rating_avg' => rand(3, 5) + rand(0, 99) / 100,
                'skills' => ['Needs services', 'Quality conscious'],
                'photo' => null,
            ]);

            $buyers[] = $user;
        }

        // Create 5 seller users (using 'freelancer' role from enum)
        $sellers = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Seller {$i}",
                'email' => "seller{$i}@marketplace.test",
                'password' => Hash::make('password'),
                'role' => 'freelancer',
                'email_verified_at' => now(),
            ]);

            // Create profile for seller
            Profile::create([
                'user_id' => $user->id,
                'bio' => "Professional service provider with years of experience",
                'rating_avg' => rand(4, 5) + rand(0, 99) / 100,
                'skills' => ['Service delivery', 'Communication', 'Quality work'],
                'photo' => null,
            ]);

            $sellers[] = $user;
        }

        // Create 20 services from sellers
        $services = [];
        $serviceCount = 0;
        $categoriesCollection = $categories instanceof Collection ? $categories : collect($categories);
        
        foreach ($sellers as $seller) {
            for ($i = 0; $i < 4; $i++) {
                $service = Service::create([
                    'user_id' => $seller->id,
                    'category_id' => $categoriesCollection->random()->id,
                    'title' => "Service {$serviceCount} from {$seller->name}",
                    'description' => "Professional service offering from {$seller->name}. High quality, fast delivery, and excellent customer support.",
                    'price' => rand(50000, 500000),
                    'status' => 'live',
                ]);
                $services[] = $service;
                $serviceCount++;
            }
        }

        // Create 30 orders
        $orders = [];
        $buyersCollection = collect($buyers);
        $sellersCollection = collect($sellers);
        $servicesCollection = collect($services);
        
        // Ensure distribution with at least 20 completed orders for payments/reviews
        $statusPool = array_merge(
            array_fill(0, 20, 'selesai'), // 20 completed
            array_fill(0, 6, 'diproses'),
            array_fill(0, 2, 'pending'),
            array_fill(0, 2, 'dibatalkan')
        );
        shuffle($statusPool);

        for ($i = 0; $i < 30; $i++) {
            $buyer = $buyersCollection->random();
            $seller = $sellersCollection->random();
            $service = $servicesCollection->random();

            $status = $statusPool[$i] ?? 'pending';

            $order = Order::create([
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'service_id' => $service->id,
                'status' => $status,
                'total_price' => $service->price,
                'created_at' => now()->subDays(rand(0, 90)),
            ]);

            $orders[] = $order;
        }

        // Create 20 payments for completed orders (use existing payments schema)
        $paymentCount = 0;
        foreach ($orders as $order) {
            if ($order->status === 'selesai' && $paymentCount < 20) {
                Payment::create([
                    'order_id' => $order->id,
                    'method' => collect(['credit_card', 'bank_transfer', 'ewallet'])->random(),
                    'status' => 'paid',
                    'paid_at' => $order->created_at->addDays(2),
                    'created_at' => $order->created_at->addDays(2),
                ]);
                $paymentCount++;
            }
        }

        // Create 15 reviews from buyers (schema: order_id, reviewer_id, rating, comment)
        $reviewCount = 0;
        foreach ($orders as $order) {
            if ($order->status === 'selesai' && $reviewCount < 15) {
                Review::create([
                    'order_id' => $order->id,
                    'reviewer_id' => $order->buyer_id,
                    'rating' => rand(3, 5),
                    'comment' => "Great service! Highly recommended. Professional and on-time delivery.",
                    'created_at' => $order->created_at->addDays(3),
                ]);
                $reviewCount++;
            }
        }

        // Create 25 chats between users
        $chatCount = 0;
        foreach ($buyers as $buyer) {
            for ($i = 0; $i < 5; $i++) {
                if ($chatCount < 25) {
                    $seller = $sellers[ array_rand($sellers) ];
                    Chat::create([
                        'sender_id' => rand(0, 1) ? $buyer->id : $seller->id,
                        'receiver_id' => rand(0, 1) ? $seller->id : $buyer->id,
                        'message' => "Hi, I'm interested in your services. Can we discuss the details?",
                        'is_read' => (bool) rand(0, 1),
                        'created_at' => now()->subDays(rand(0, 60)),
                    ]);
                    $chatCount++;
                }
            }
        }

        echo "✅ ClientWorkspaceSeeder completed successfully!\n";
        echo "📊 Generated data:\n";
        echo "   • 10 Buyers\n";
        echo "   • 5 Sellers\n";
        echo "   • 20 Services\n";
        echo "   • 30 Orders\n";
        echo "   • 20 Payments\n";
        echo "   • 15 Reviews\n";
        echo "   • 25 Chats\n";
    }
}
