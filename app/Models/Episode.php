<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Episode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'duration',
        'episode_number',
        'file_path',
        'podcast_id',
        'category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'duration' => 'integer',
        'podcast_id' => 'integer',
        'category_id' => 'integer',
    ];

    public function scopeFilterHasTopics($query, string $topics)
    {
        $topicsArray = explode(',', $topics);

        return $query->whereHas('topics', function ($query) use ($topicsArray) {
            $query->whereIn('id', $topicsArray);
        });
    }

    public function scopeFilterHasGuests($query, string $guests)
    {
        $guestsArray = explode(',', $guests);

        return $query->whereHas('guests', function ($query) use ($guestsArray) {
            $query->whereIn('id', $guestsArray);
        });
    }

    public function scopeLanguage($query, string $language)
    {
        return $query->whereHas('podcast', function ($query) use ($language) {
            $query->where('language', $language);
        });
    }

    public function podcast(): BelongsTo
    {
        return $this->belongsTo(Podcast::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class);
    }

    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(Guest::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'liked_episodes');
    }
}
