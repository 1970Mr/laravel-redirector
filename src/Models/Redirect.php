<?php

namespace Mr1970\LaravelRedirector\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Mr1970\LaravelRedirector\Facades\Redirector;

/**
 * @property mixed $source_url
 * @property string $destination_url
 * @property int $status_code
 * @property int $is_active
 *
 * @method static Builder active()
 */
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
            Redirector::forgetCache($cacheMethod, $redirect);
        });

        static::deleted(static function ($redirect) use ($cacheMethod) {
            Redirector::forgetCache($cacheMethod, $redirect);
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
            set: static fn (string $value) => Redirector::sanitizeUrl($value),
        );
    }

    protected function destinationUrl(): Attribute
    {
        return Attribute::make(
            set: static fn (string $value) => Redirector::sanitizeUrl($value),
        );
    }
}
