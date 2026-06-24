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
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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

        // Clear dependent tables to avoid duplicate unique keys from previous seeds
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('services')->truncate();
        DB::table('orders')->truncate();
        DB::table('payments')->truncate();
        DB::table('reviews')->truncate();
        DB::table('chats')->truncate();
        DB::table('profiles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Reuse users created by UserSeeder. Ensure minimum counts (buyers:5, sellers:3)
        $buyers = User::where('role', 'mahasiswa')->take(5)->get()->all();
        while (count($buyers) < 5) {
            $i = count($buyers) + 1;
            $user = User::create([
                'name' => "Buyer {$i}",
                'email' => "buyer{$i}@marketplace.test",
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
            ]);
            $buyers[] = $user;
        }

        $sellers = User::where('role', 'freelancer')->take(3)->get()->all();
        while (count($sellers) < 3) {
            $i = count($sellers) + 1;
            $user = User::create([
                'name' => "Seller {$i}",
                'email' => "seller{$i}@marketplace.test",
                'password' => Hash::make('password'),
                'role' => 'freelancer',
                'email_verified_at' => now(),
            ]);
            $sellers[] = $user;
        }

        // Ensure profiles exist for buyers and sellers
        foreach ($buyers as $buyer) {
            Profile::firstOrCreate([
                'user_id' => $buyer->id,
            ], [
                'bio' => "I'm a buyer looking for quality services",
                'rating_avg' => rand(3, 5) + rand(0, 99) / 100,
                'skills' => ['Needs services', 'Quality conscious'],
                'photo' => null,
            ]);
        }

        foreach ($sellers as $seller) {
            Profile::firstOrCreate([
                'user_id' => $seller->id,
            ], [
                'bio' => "Professional service provider with years of experience",
                'rating_avg' => rand(4, 5) + rand(0, 99) / 100,
                'skills' => ['Service delivery', 'Communication', 'Quality work'],
                'photo' => null,
            ]);
        }

        // Create between 10 and 20 services distributed among sellers
        $services = [];
        $serviceCount = rand(10, 20);
        $categoriesCollection = $categories instanceof Collection ? $categories : collect($categories);
        for ($i = 0; $i < $serviceCount; $i++) {
            $seller = $sellers[array_rand($sellers)];
            $service = Service::create([
                'user_id' => $seller->id,
                'category_id' => $categoriesCollection->random()->id,
                'title' => "Service {$i} from {$seller->name}",
                'description' => "Professional service offering from {$seller->name}. High quality, fast delivery, and excellent customer support.",
                'price' => rand(50000, 500000),
                'status' => 'live',
            ]);
            $services[] = $service;
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

        // Track sequence counts per date to build unique order codes
        $countsByDate = [];
        for ($i = 0; $i < 30; $i++) {
            $buyer = $buyersCollection->random();
            $seller = $sellersCollection->random();
            $service = $servicesCollection->random();

            $status = $statusPool[$i] ?? 'pending';

            // Determine a realistic created_at date for the order
            $orderCreatedAt = now()->subDays(rand(0, 90));
            $dateKey = $orderCreatedAt->toDateString();
            $countsByDate[$dateKey] = ($countsByDate[$dateKey] ?? 0) + 1;
            $sequence = str_pad($countsByDate[$dateKey], 4, '0', STR_PAD_LEFT);
            $orderCode = 'ORD-' . $orderCreatedAt->format('Ymd') . '-' . $sequence;

            $order = Order::create([
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'service_id' => $service->id,
                'status' => $status,
                'total_price' => $service->price,
                'created_at' => $orderCreatedAt,
                'order_code' => $orderCode,
            ]);

            // Create a payment for every order to reach 30 payments
            Payment::create([
                'order_id' => $order->id,
                'method' => collect(['credit_card', 'bank_transfer', 'ewallet'])->random(),
                'status' => 'paid',
                'paid_at' => $orderCreatedAt->addDays(1),
                'created_at' => $orderCreatedAt->addDays(1),
            ]);

            $orders[] = $order;
        }

        // Create up to 20 reviews for completed orders
        $reviewCount = 0;
        foreach ($orders as $order) {
            if ($order->status === 'selesai' && $reviewCount < 20) {
                Review::create([
                    'order_id' => $order->id,
                    'reviewer_id' => $order->buyer_id,
                    'rating' => rand(3, 5),
                    'comment' => "Great service! Highly recommended. Professional and on-time delivery.",
                    'created_at' => $order->created_at->addDays(2),
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
        echo "   • " . count($buyers) . " Buyers\n";
        echo "   • " . count($sellers) . " Sellers\n";
        echo "   • " . $serviceCount . " Services\n";
        echo "   • 30 Orders\n";
        echo "   • 30 Payments\n";
        echo "   • " . $reviewCount . " Reviews\n";
        echo "   • 25 Chats\n";
    }
}
