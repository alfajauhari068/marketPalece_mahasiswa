<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Category;
use App\Models\Order;
use App\Models\ServiceImage;
use App\Models\User;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = ['user_id', 'title', 'description', 'price', 'category_id', 'status'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    protected $appends = [
        'primary_image'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ServiceImage::class)->orderBy('sort_order', 'asc');
    }

    public function getPrimaryImageAttribute(): ?string
    {
        return optional(
            $this->images->sortBy('sort_order')->first()
        )->url;
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(\App\Models\Review::class);
    }
}
