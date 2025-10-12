<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Polymorphic relationship - User images
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get user's posts
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get user's comments
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get user's profile image URL
     */
    protected function profileImageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $profileImage = $this->images()
                    ->where('imageable_type', User::class)
                    ->where('imageable_id', $this->id)
                    ->first();

                if ($profileImage) {
                    return '/storage/' . $profileImage->path;
                }

                return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
            }
        );
    }

    /**
     * Get Filament avatar URL
     */
    public function getFilamentAvatarUrl(): ?string
    {
        // Use fresh query to avoid caching issues
        $profileImage = $this->images()
            ->where('imageable_type', self::class)
            ->where('imageable_id', $this->id)
            ->latest()
            ->first();

        if ($profileImage && $profileImage->path) {
            $url = '/storage/' . $profileImage->path;
            // Add timestamp to prevent browser caching
            return $url . '?t=' . $profileImage->updated_at->timestamp;
        }

        return null;
    }

    /**
     * Boot method - User ဖန်တီးတိုင်း default role assign လုပ်ခြင်း
     */
    protected static function booted(): void
    {
        static::created(function (User $user) {
            // User အသစ်ဖန်တီးတိုင်း role မရှိရင် 'user' role ကို default assign လုပ်မယ်
            if (!$user->roles()->exists()) {
                $user->assignRole('user');
            }
        });
    }
}
