<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'image_url',
        'premium_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'premium_until' => 'timestamp',
    ];

    public function havePremium(): Attribute
    {
        return new Attribute(get: function () {
            return $this->premium_until && now()->timestamp < $this->premium_until;
        });
    }

    public function savedPodcasts(): BelongsToMany
    {
        return $this->belongsToMany(Podcast::class, 'saved_podcasts');
    }

    public function likedEpisodes(): BelongsToMany
    {
        return $this->belongsToMany(Episode::class, 'liked_episodes');
    }
}
