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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel orders dengan foreign key constraint wajib [cite: 588, 642-644]
            // cascadeOnDelete digunakan agar jika data order dihapus, data payment terkait ikut bersih [cite: 645-647]
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete(); 
            
            $table->string('method'); // Menyimpan metode (misal: Transfer BCA, GoPay, OVO) [cite: 589, 800]
            $table->string('status'); // Menyimpan status pembayaran (misal: unpaid, paid) [cite: 590, 540-541]
            $table->timestamp('paid_at')->nullable(); // Mencatat waktu pembayaran sukses dilakukan [cite: 591]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
