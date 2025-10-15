<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolAchievement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'school_achievements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_setting_id',
        'ac_year',
        'achievement_list',
        'order',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'achievement_list' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope to get only active achievements.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by order column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get the site setting that owns the achievement.
     */
    public function siteSetting()
    {
        return $this->belongsTo(SiteSetting::class);
    }
}
