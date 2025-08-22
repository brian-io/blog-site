<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'ip_address',
        'user_agent',
        'properties'
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    const ACTION_LOGIN = 'login';
    const ACTION_REGISTER = 'register';
    const ACTION_LOGOUT = 'logout';
    const ACTION_BLOG_CREATED = 'blog_created';
    const ACTION_BLOG_UPDATED = 'blog_updated';
    const ACTION_BLOG_PUBLISHED = 'blog_published';
    const ACTION_BLOG_UNPUBLISHED = 'blog_unpublished';
    const ACTION_BLOG_DELETED = 'blog_deleted';
    const ACTION_COMMENT_CREATED = 'comment_created';
    const ACTION_COMMENT_APPROVED = 'comment_approved';
    const ACTION_NEWSLETTER_SIGNUP = 'newsletter_signup';
    const ACTION_USER_UPDATED = 'user_updated';
    const ACTION_USER_ACTIVATED = 'user_activated';
    const ACTION_USER_DEACTIVATED = 'user_deactivated';
    const ACTION_USER_DELETED = 'user_deleted';
    const ACTION_COMMENT_DELETED = 'comment_deleted';
    const ACTION_COMMENT_RESTORED = 'comment_restored';
    const ACTION_COMMENT_MARKED_SPAM = 'comment_marked_spam';
    const ACTION_COMMENT_REJECTED = 'comment_rejected';



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public static function log(string $action, string $description, $subject = null, array $properties = []): self
    {
        return static::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'properties' => $properties,
        ]);
    }
}