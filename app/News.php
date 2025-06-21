<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    //
    protected $guarded = ['id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title before saving
        static::creating(function ($news) {
            if (!$news->slug) {
                $news->slug = Str::slug($news->title);
            }
        });

        static::updating(function ($news) {
            if ($news->isDirty('title') && !$news->isDirty('slug')) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function getRouteKeyName()
    // {
    //     return 'id';
    // }

    public function getIsPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y H:i') : 'Not Published';
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'draft':
                return 'Draft';
            case 'published':
                return 'Published';
            case 'archived':
                return 'Archived';
            default:
                return 'Unknown';
        }
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

}
