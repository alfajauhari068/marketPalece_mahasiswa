<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'service_id')) {
                $table->foreignId('service_id')
                      ->nullable()
                      ->constrained('services')
                      ->onDelete('set null')
                      ->onUpdate('cascade');
            }

            if (!Schema::hasColumn('reviews', 'buyer_id')) {
                $table->foreignId('buyer_id')
                      ->nullable()
                      ->constrained('users')
                      ->onDelete('set null')
                      ->onUpdate('cascade');
            }

            if (!Schema::hasColumn('reviews', 'seller_id')) {
                $table->foreignId('seller_id')
                      ->nullable()
                      ->constrained('users')
                      ->onDelete('set null')
                      ->onUpdate('cascade');
            }

            if (!Schema::hasColumn('reviews', 'feedback')) {
                $table->text('feedback')->nullable()->after('comment');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasColumn('reviews', 'feedback')) {
                $table->dropColumn('feedback');
            }

            if (Schema::hasColumn('reviews', 'seller_id')) {
                $table->dropForeign(['seller_id']);
                $table->dropColumn('seller_id');
            }

            if (Schema::hasColumn('reviews', 'buyer_id')) {
                $table->dropForeign(['buyer_id']);
                $table->dropColumn('buyer_id');
            }

            if (Schema::hasColumn('reviews', 'service_id')) {
                $table->dropForeign(['service_id']);
                $table->dropColumn('service_id');
            }
        });
    }
};
