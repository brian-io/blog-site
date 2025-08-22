<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Blog;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'bio',
        'website',
        'is_active',
        'email_verified_at',
        'comment_trust_score' // Added missing field
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
            'comment_trust_score' => 'integer', // Added cast for trust score
            'is_active' => 'boolean' // Added cast for boolean field
        ];
    }

    const ROLE_ADMIN = 'admin';
    const ROLE_AUTHOR = 'author';
    const ROLE_USER = 'user';
    
    const TRUSTED_COMMENT_THRESHOLD = 5; // Extracted magic number to constant

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isAuthor(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_AUTHOR]);
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function canManageContent(): bool
    {
        return $this->isAdmin() || $this->isAuthor();
    }
    
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function incrementTrustScore()
    {
        $this->increment('comment_trust_score');
    }

    public function isTrusted(): bool
    {
        return ($this->comment_trust_score ?? 0) >= self::TRUSTED_COMMENT_THRESHOLD;
    }

    /**
     * Check if the user has voted on a specific comment
     *
     * @param Comment $comment
     * @param int|null $voteType (1 for upvote, -1 for downvote, null for any vote)
     * @return bool
     */
    public function hasVoted($comment, $voteType = null): bool
    {
        $query = $this->commentVotes()
                ->where('user_id', $this->id)
                ->where('comment_id', $comment->id);

        if ($voteType !== null) {
            $query->where('vote', $voteType);
        }

        return $query->exists();
    }

    /**
     * Get the user's vote on a specific comment
     *
     * @param Comment $comment
     * @return int|null (1 for upvote, -1 for downvote, null if no vote)
     */
    public function getVoteFor($comment): ?int
    {
        $vote = $this->commentVotes()->where('comment_id', $comment->id)->first();
        return $vote ? $vote->vote : null;
    }

    /**
     * Vote on a comment with transaction support for ACID compliance
     *
     * @param Comment $comment
     * @param int $voteType (1 for upvote, -1 for downvote)
     * @return array
     */
    public function voteOnComment($comment, $voteType): array
    {
        return DB::transaction(function() use ($comment, $voteType) {
            // Check if user already voted on this comment
            $existingVote = $this->commentVotes()
                        ->where('comment_id', $comment->id)->first();
            
            if ($existingVote) {
                if ($existingVote->vote == $voteType) {
                    // Remove vote if clicking the same vote type
                    $existingVote->delete();
                    $userVote = null;
                } else {
                    // Update vote if clicking different vote type
                    $existingVote->update(['vote' => $voteType]);
                    $userVote = $voteType;
                }
            } else {
                // Create new vote
                $this->commentVotes()->create([
                    'comment_id' => $comment->id,
                    'vote' => $voteType
                ]);
                $userVote = $voteType;
            }
            
            // Recalculate comment score using aggregate function for consistency
            $comment->refresh();
            $newScore = $comment->calculateVoteScore();
            
            return [
                'success' => true,
                'vote_score' => $newScore,
                'user_vote' => $userVote
            ];
        });
    }

    /**
     * Define relationship with comment votes
     */
    public function commentVotes()
    {
        return $this->hasMany(Vote::class);
    }

    public function activities()
    {
        return $this->hasMany(UserActivity::class);
    }
    
    public function getInitialsAttribute(): string
    {
        return collect(explode(' ', $this->name))
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->join('');
    }
}