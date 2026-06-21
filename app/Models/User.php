<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function ordersAsBuyer(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    public function ordersAsSeller(): HasMany
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function chatsAsSender(): HasMany
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function chatsAsReceiver(): HasMany
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBuyer(): bool
    {
        // Accept multiple synonyms for buyer (legacy DB values and frontend values)
        return in_array($this->role, ['buyer', 'user', 'mahasiswa', 'client'], true);
    }

    public function isSeller(): bool
    {
        // Accept multiple synonyms for seller
        return in_array($this->role, ['seller', 'freelancer'], true);
    }
}
