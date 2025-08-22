<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = ['user_id', 'comment_id', 'vote'];

    protected $casts = [
        'vote' => 'integer'
    ];

    // Add validation constants for vote values
    const UPVOTE = 1;
    const DOWNVOTE = -1;
    
    // Add validation for vote values
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($vote) {
            if (!in_array($vote->vote, [self::UPVOTE, self::DOWNVOTE])) {
                throw new \InvalidArgumentException('Vote must be 1 (upvote) or -1 (downvote)');
            }
        });
        
        static::updating(function ($vote) {
            if (!in_array($vote->vote, [self::UPVOTE, self::DOWNVOTE])) {
                throw new \InvalidArgumentException('Vote must be 1 (upvote) or -1 (downvote)');
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
    
    public function isUpvote(): bool
    {
        return $this->vote === self::UPVOTE;
    }
    
    public function isDownvote(): bool
    {
        return $this->vote === self::DOWNVOTE;
    }
}