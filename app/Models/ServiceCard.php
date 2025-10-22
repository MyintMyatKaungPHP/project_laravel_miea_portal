<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ServiceCard extends Model
{
    protected $fillable = [
        'title',
        'details',
        'image',
        'overlay_color',
        'link',
        'tag_name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        // Return full URL for public storage
        return Storage::disk('public')->url($this->image);
    }
}
