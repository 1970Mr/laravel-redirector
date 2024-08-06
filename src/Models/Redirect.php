<?php

namespace Mr1970\LaravelRedirector\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    protected $fillable = [
        'source_url',
        'destination_url',
        'status_code',
        'is_active',
    ];

    protected static function booted(): void
    {
        $cacheMethod = config('redirector.cache_method', 'full_list');
        static::saved(static function ($redirect) use ($cacheMethod) {
            self::forgetCache($cacheMethod, $redirect);
        });

        static::deleted(static function ($redirect) use ($cacheMethod) {
            self::forgetCache($cacheMethod, $redirect);
        });

        parent::booted();
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    protected function sourceUrl(): Attribute
    {
        return Attribute::make(
            set: static fn(string $value) => trim($value, '/'),
        );
    }

    protected function destinationUrl(): Attribute
    {
        return Attribute::make(
            set: static fn(string $value) => trim($value, '/'),
        );
    }

    private static function forgetCache(mixed $cacheMethod, $redirect): void
    {
        if ($cacheMethod === 'full_list') {
            Cache::forget('redirects_list');
        } else {
            Cache::forget("redirect_{$redirect->source_url}");
        }
    }
}
