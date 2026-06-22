<?php

namespace Tests\Feature;

use App\Models\Chat;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DashboardClientTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    protected $user;
    protected $seller;

    public function setUp(): void
    {
        parent::setUp();

        // Clear cache between tests to prevent cross-test pollution
        Cache::flush();

        // Create buyer user (match DB enum)
        $this->user = User::factory()->create(['role' => 'mahasiswa']);
        $this->user->profile()->create(['rating_avg' => 4.5]);

        // Create seller user
        $this->seller = User::factory()->create(['role' => 'freelancer']);
        $this->seller->profile()->create(['rating_avg' => 4.8]);
    }

    /**
     * Test: Dashboard index page loads for authenticated user
     */
    public function test_dashboard_index_loads_for_authenticated_user()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.home'));

        $response->assertStatus(200);
        $response->assertViewIs('klien.dashboard.index');
    }

    /**
     * Test: Unauthenticated user cannot access dashboard
     */
    public function test_unauthenticated_user_cannot_access_dashboard()
    {
        $response = $this->get(route('dashboard.home'));

        // Laravel's auth middleware redirects guests to login (302)
        $response->assertRedirect(route('login'));
    }

    /**
     * Test: Dashboard displays correct statistics
     */
    public function test_dashboard_displays_correct_statistics()
    {
        // Create orders for the user
        $activeOrder = Order::factory()->create([
            'buyer_id' => $this->user->id,
            'seller_id' => $this->seller->id,
            'status' => 'pending',
            'total_price' => 100000,
        ]);

        $completedOrder = Order::factory()->create([
            'buyer_id' => $this->user->id,
            'seller_id' => $this->seller->id,
            'status' => 'selesai',
            'total_price' => 50000,
        ]);

        // Create payment for completed order (align with payments schema)
        Payment::factory()->paid()->create([
            'order_id' => $completedOrder->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.home'));

        $response->assertViewHasAll(['stats', 'recentOrders', 'recommendedServices']);

        // Verify stats contain expected data
        $stats = $response->viewData('stats');
        $this->assertEquals(1, $stats[0]['value']); // Active orders
        $this->assertEquals(1, $stats[1]['value']); // Completed orders
    }

    /**
     * Test: Recent orders displayed on dashboard
     */
    public function test_recent_orders_displayed_on_dashboard()
    {
        $service = Service::factory()->create(['user_id' => $this->seller->id, 'status' => 'live']);
        Order::factory()->create([
            'buyer_id' => $this->user->id,
            'seller_id' => $this->seller->id,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.home'));

        $this->assertNotEmpty($response->viewData('recentOrders'));
    }

    /**
     * Test: Recommended services displayed on dashboard
     */
    public function test_recommended_services_displayed_on_dashboard()
    {
        Service::factory()->count(5)->create(['status' => 'live', 'user_id' => $this->seller->id]);

        $response = $this->actingAs($this->user)->get(route('dashboard.home'));

        $services = $response->viewData('recommendedServices');
        $this->assertTrue($services->count() > 0);
    }

    /**
     * Test: Orders page lists user's orders
     */
    public function test_orders_page_lists_user_orders()
    {
        $service = Service::factory()->create(['user_id' => $this->seller->id, 'status' => 'live']);
        Order::factory()->count(3)->create([
            'buyer_id' => $this->user->id,
            'seller_id' => $this->seller->id,
            'service_id' => $service->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.orders'));

        $response->assertStatus(200);
        $response->assertViewIs('klien.dashboard.orders');
        $this->assertEquals(3, $response->viewData('orders')->total());
    }

    /**
     * Test: Orders search functionality works
     */
    public function test_orders_search_functionality()
    {
        $service = Service::factory()->create([
            'user_id' => $this->seller->id,
            'status' => 'live',
            'title' => 'Web Development',
        ]);

        Order::factory()->create([
            'buyer_id' => $this->user->id,
            'seller_id' => $this->seller->id,
            'service_id' => $service->id,
        ]);

        // Search by service title
        $response = $this->actingAs($this->user)->get(route('dashboard.orders') . '?search=Web');

        $this->assertTrue($response->viewData('orders')->count() > 0);
    }

    /**
     * Test: Messages page shows user conversations
     */
    public function test_messages_page_shows_conversations()
    {
        Chat::factory()->count(3)->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->seller->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.messages'));

        $response->assertStatus(200);
        $response->assertViewIs('klien.dashboard.messages');
        $this->assertTrue($response->viewData('chats')->count() > 0);
    }

    /**
     * Test: Messages search functionality works
     */
    public function test_messages_search_functionality()
    {
        Chat::factory()->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->seller->id,
            'message' => 'Hello, I need help with this project',
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.messages') . '?search=project');

        $this->assertTrue($response->viewData('chats')->count() > 0);
    }

    /**
     * Test: Message detail page loads conversation
     */
    public function test_message_detail_loads_conversation()
    {
        $chat = Chat::factory()->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->seller->id,
        ]);

        Chat::factory()->count(3)->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->seller->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.message.detail', $chat->id));

        $response->assertStatus(200);
        $response->assertViewIs('klien.dashboard.message-detail');
        $this->assertNotEmpty($response->viewData('chat')['messages']);
    }

    /**
     * Test: Notifications page loads
     */
    public function test_notifications_page_loads()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.notifications'));

        $response->assertStatus(200);
        $response->assertViewIs('klien.dashboard.notifications');
    }

    /**
     * Test: Profile page displays user information
     */
    public function test_profile_page_displays_user_information()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('klien.dashboard.profile');

        $profile = $response->viewData('profile');
        $this->assertEquals($this->user->name, $profile['name']);
        $this->assertEquals($this->user->email, $profile['email']);
    }

    /**
     * Test: Profile edit form loads
     */
    public function test_profile_edit_form_loads()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.profile.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('klien.dashboard.profile-edit');
    }

    /**
     * Test: Profile update succeeds
     */
    public function test_profile_update_succeeds()
    {
        $data = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'bio' => 'My new bio',
            'skills' => 'PHP, Laravel, JavaScript',
        ];

        $response = $this->actingAs($this->user)
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)
            ->post(route('dashboard.profile.update'), $data);

        $response->assertRedirect(route('dashboard.profile'));
        $this->user->refresh();
        $this->assertEquals('Updated Name', $this->user->name);
        $this->assertEquals('updated@example.com', $this->user->email);
    }

    /**
     * Test: Database queries execute without N+1 issues
     */
    public function test_dashboard_queries_optimized()
    {
        // Create test data
        Service::factory()->count(10)->create(['status' => 'live', 'user_id' => $this->seller->id]);
        Order::factory()->count(5)->create([
            'buyer_id' => $this->user->id,
            'seller_id' => $this->seller->id,
        ]);

        DB::enableQueryLog();

        $response = $this->actingAs($this->user)->get(route('dashboard.home'));

        $queryCount = count(DB::getQueryLog());
        DB::disableQueryLog();

        // Should have reasonable query count (not 50+)
        $this->assertLessThan(30, $queryCount);
        $response->assertStatus(200);
    }

    /**
     * Test: Order detail page shows order information
     */
    public function test_order_detail_shows_correct_information()
    {
        $service = Service::factory()->create(['user_id' => $this->seller->id]);
        $order = Order::factory()->create([
            'buyer_id' => $this->user->id,
            'seller_id' => $this->seller->id,
            'service_id' => $service->id,
            'total_price' => 100000,
        ]);

        Payment::factory()->paid()->create([
            'order_id' => $order->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('dashboard.order.detail', $order->id));

        $response->assertStatus(200);
        $orderData = $response->viewData('order');
        $this->assertEquals($service->title, $orderData['title']);
    }

    /**
     * Test: User cannot access other user's orders
     */
    public function test_user_cannot_access_other_user_orders()
    {
        $otherUser = User::factory()->create();
        $order = Order::factory()->create(['buyer_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get(route('dashboard.order.detail', $order->id));

        $response->assertStatus(404);
    }

    /**
     * Test: Empty states display when no data exists
     */
    public function test_empty_states_display_correctly()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.orders'));

        $response->assertStatus(200);
        $this->assertEquals(0, $response->viewData('orders')->total());
    }
}
