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
        Schema::table('payments', function (Blueprint $table) {
            // Add transaction_id for payment gateway reference
            if (!Schema::hasColumn('payments', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->unique()->after('order_id');
            }

            // Add amount to track payment total snapshot
            if (!Schema::hasColumn('payments', 'amount')) {
                $table->decimal('amount', 12, 2)->nullable()->after('transaction_id');
            }
        });

        // Update status enum to include 'failed' state
        // Note: For existing enum, we change the enum definition
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'status')) {
                $table->enum('status', ['pending', 'paid', 'failed'])->default('pending')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Revert status enum to original
            if (Schema::hasColumn('payments', 'status')) {
                $table->enum('status', ['pending', 'paid'])->default('pending')->change();
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'transaction_id')) {
                $table->dropUnique(['transaction_id']);
                $table->dropColumn('transaction_id');
            }

            if (Schema::hasColumn('payments', 'amount')) {
                $table->dropColumn('amount');
            }
        });
    }
};
