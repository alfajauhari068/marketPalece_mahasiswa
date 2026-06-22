<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ServiceImage extends Model
{
    use HasFactory;

    protected $table = 'service_images';

    protected $fillable = ['service_id', 'path', 'sort_order'];

    protected $appends = [
        'url'
    ];

    public function getUrlAttribute(): string
    {
        if (! $this->path) {
            return asset('images/no-image.png');
        }

        if (Storage::disk('public')->exists($this->path)) {
            return asset('storage/'.$this->path);
        }

        Log::warning('Service image missing', [
            'service_image_id' => $this->id,
            'service_id' => $this->service_id,
            'path' => $this->path,
        ]);

        return asset('images/no-image.png');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
