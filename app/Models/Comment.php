<?php

namespace App\Models;

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
        'author_name',
        'author_email',
        'author_website',
        'content',
        'status',
        'ip_address',
        'user_agent',
        'spam_score'
    ];

    protected $casts = [
        'spam_score' => 'decimal:2',
    ];

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
        return $this->hasMany(Comment::class, 'parent_id');
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

    public function voteScore()
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }

    public function userVote(User $user)
    {
        return $this->votes()->where('user_id', $user->id)->value('vote');
    }git init

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
    
    public function needsModeration(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function getAuthorDisplayName(): string
    {
        return $this->user ? $this->user->name : $this->author_name ?? 'Guest';
    }

    public function getAuthorInitial(): string
    {
        return strtoupper(substr($this->getAuthorDisplayName(), 0, 1));
    }
}