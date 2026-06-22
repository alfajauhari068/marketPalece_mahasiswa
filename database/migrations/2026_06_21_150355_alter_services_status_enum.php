<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['draft', 'paused', 'live'])->default('draft')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Make enum-to-enum migration safe by converting to a temporary string column,
        // update values, then change back to the legacy enum.
        // 1) Change enum -> varchar
        DB::statement("ALTER TABLE services MODIFY status VARCHAR(32) NOT NULL DEFAULT 'active'");

        // 2) Map new statuses back to legacy values
        DB::table('services')->where('status', 'live')->update(['status' => 'active']);
        DB::table('services')->where('status', 'draft')->update(['status' => 'inactive']);
        DB::table('services')->where('status', 'paused')->update(['status' => 'inactive']);

        // 3) Convert varchar back to legacy enum
        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }
};
