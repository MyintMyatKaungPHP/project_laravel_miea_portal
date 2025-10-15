<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProgrammeImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'programme_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_setting_id',
        'programme_name',
        'images',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'images' => 'array',
    ];


    /**
     * Scope to filter by programme name.
     */
    public function scopeByProgrammeName($query, $programmeName)
    {
        return $query->where('programme_name', $programmeName);
    }

    /**
     * Get the images URLs.
     */
    public function getImagesUrlsAttribute(): array
    {
        if (!$this->images) {
            return [];
        }

        return array_map(function ($image) {
            return Storage::url($image);
        }, $this->images);
    }

    /**
     * Get the site setting that owns the programme.
     */
    public function siteSetting()
    {
        return $this->belongsTo(SiteSetting::class);
    }
}
