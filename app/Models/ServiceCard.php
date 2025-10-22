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

    public function setImageAttribute($value)
    {
        // Fix the path if it's using hyphens instead of underscores
        if ($value && str_contains($value, 'service-cards/')) {
            // Get the old path and new path
            $oldPath = $value;
            $newPath = str_replace('service-cards/', 'site/service_cards/', $value);

            // Move the file from old location to new location if it exists
            $disk = Storage::disk('public');
            if ($disk->exists($oldPath)) {
                // Ensure the target directory exists
                $targetDir = dirname($newPath);
                if (!$disk->exists($targetDir)) {
                    $disk->makeDirectory($targetDir, 0755, true);
                }

                // Move the file
                $disk->move($oldPath, $newPath);
            }

            $value = $newPath;
        }

        $this->attributes['image'] = $value;
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        // Return full URL for public storage
        return Storage::disk('public')->url($this->image);
    }
}
