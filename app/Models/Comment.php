<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'blog_id',
        'user_id',
        'parent_id',
        'content',
        'user_name',
        'user_email',
        'status',
        'ip_address',
        'user_agent',
        'spam_score',
    ];

    protected $casts = [
        'spam_score' => 'decimal:2',
        'vote_score' => 'integer',
    ];

    protected $appends =['vote_score'];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_SPAM = 'spam';

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->where('status', self::STATUS_APPROVED)
                    ->orderBy('created_at', 'asc');
    }

    // Add a method to get replies with nested loading when needed
    public function repliesWithNested()
    {
        return $this->replies()
                    ->with(['replies' => function($query) {
                        $query->where('status', self::STATUS_APPROVED);
                    }]);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function upvotes()
    {
        return $this->votes()->where('vote', 1);
    }

    public function downvotes()
    {
        return $this->votes()->where('vote', -1);
    }

    public function calculateVoteScore(): int
    {
        return $this->votes()->sum('vote');
    }
    
    public function getVoteScoreAttribute(): int
    {
        if (isset($this->attributes['votes_sum_vote'])){
            return (int) $this->attributes['votes_sum_vote'];
        }

        return $this->calculateVoteScore();
    }

    public function scopeWithVoteScore($query)
    {
        return $query->withSum('votes', 'vote');
    }

    public function userVote(?User $user = null): ?int
{
        $user ??= Auth::user(); // null coalescing assignment
        if (!$user) return null;

        // if votes already loaded, filter in memory
        if ($this->relationLoaded('votes')) {
            return $this->votes->firstWhere('user_id', $user->id)?->vote;
        }

        // fallback: query DB
        return $this->votes()->where('user_id', $user->id)->value('vote');
}

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }
    
    public function isSpam(): bool
    {
        return $this->status === self::STATUS_SPAM;
    }
    
    public function needsModeration(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function getAuthorDisplayName(): string
    {
        return $this->user?->name ?? $this->user_name ?? 'Guest';
    }

    public function getAuthorInitial(): string
    {
        $displayName = $this->getAuthorDisplayName();
        return strtoupper(substr($displayName, 0, 1));
    }
}