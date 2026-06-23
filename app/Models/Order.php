<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['order_code', 'buyer_id', 'seller_id', 'service_id', 'quantity', 'subtotal', 'status', 'total_price'];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function orderDetail(): HasOne
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Boot method to auto-generate order code on creation.
     * Pattern: ORD-YYYYMMDD-XXXX (e.g., ORD-20260622-0001)
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_code)) {
                $today = now()->format('Ymd');
                
                // Get the count of orders created today
                $countToday = static::whereDate('created_at', now()->toDateString())->count();
                
                // Generate unique sequence number (1-based)
                $sequence = str_pad($countToday + 1, 4, '0', STR_PAD_LEFT);
                
                // Set order code
                $order->order_code = "ORD-{$today}-{$sequence}";
            }
        });
    }
}
