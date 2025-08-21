<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class Blog extends Model
{
    use HasFactory;
    // specify fillable fields
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'user_id',
        'published_at',
        'meta_title',
        'meta_description',
        'reading_time',
        'view_count'
    ];
    protected $casts = [
        'published_at' => 'datetime',
        'view_count' => 'integer',
        'reading_time' => 'integer',
    ];

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_SCHEDULED = 'scheduled';
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            if (empty($blog->reading_time)) {
                $blog->reading_time = $blog->calculateReadingTime();
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->getOriginal('slug'))) {
                $blog->slug = Str::slug($blog->title);
            }
            if ($blog->isDirty('content')) {
                $blog->reading_time = $blog->calculateReadingTime();
            }
        });
    }

   /**
   * Get the user that owns the blog.
   */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id');
    }

    public function approvedComments()
    {
        return $this->comments()
                    ->where('status', Comment::STATUS_APPROVED)
                    ->orderBy('created_at', 'desc');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }

    /**
     *  Many-to-many relationship with categories
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_category');
    }

    public function pageViews()
    {
        return $this->hasMany(PageView::class);
    }

    // Scope for published posts
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    // Scope for draft posts
    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function scopeByAuthor($query, $authorId)
    {
        return $query->where('user_id', $authorId);
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED && 
               $this->published_at <= now();
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isScheduled(): bool
    {
        return $this->status === self::STATUS_SCHEDULED;
    }

    public function canBeViewedBy(?User $user): bool
    {
        if ($this->isPublished()) {
            return true;
        }

        if (!$user) {
            return false;
        }

        return $user->isAdmin() || $user->id === $this->user_id;
    }

    public function calculateReadingTime(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, ceil($wordCount / 200)); // Assume 200 words per minute
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today())
            ->get();
    }
}


