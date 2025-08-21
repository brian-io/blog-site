<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'type',
        'reason',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    const TYPE_BLACKLIST = 'blacklist';
    const TYPE_WHITELIST = 'whitelist';

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    public function scopeBlacklist($query)
    {
        return $query->where('type', self::TYPE_BLACKLIST);
    }

    public function scopeWhitelist($query)
    {
        return $query->where('type', self::TYPE_WHITELIST);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public static function isBlocked(string $ip): bool
    {
        return static::active()
                    ->blacklist()
                    ->where('ip_address', $ip)
                    ->exists();
    }

    public static function isWhitelisted(string $ip): bool
    {
        return static::active()
                    ->whitelist()
                    ->where('ip_address', $ip)
                    ->exists();
    }
}