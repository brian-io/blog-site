<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_tag');
    }

    public function publishedblogs()
    {
        return $this->blogs()->published();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
