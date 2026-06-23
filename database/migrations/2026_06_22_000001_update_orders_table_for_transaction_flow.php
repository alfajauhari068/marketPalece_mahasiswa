<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add order_code for invoice numbering
            if (!Schema::hasColumn('orders', 'order_code')) {
                $table->string('order_code')->nullable()->unique()->after('id');
            }

            // Add quantity for multi-quantity orders
            if (!Schema::hasColumn('orders', 'quantity')) {
                $table->integer('quantity')->default(1)->after('service_id');
            }

            // Add subtotal to store price snapshot during checkout
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->nullable()->after('quantity');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'order_code')) {
                $table->dropUnique(['order_code']);
                $table->dropColumn('order_code');
            }

            if (Schema::hasColumn('orders', 'quantity')) {
                $table->dropColumn('quantity');
            }

            if (Schema::hasColumn('orders', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
        });
    }
};
