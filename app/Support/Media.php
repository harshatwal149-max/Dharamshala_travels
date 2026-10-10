<?php

namespace App\Support;

use Illuminate\Support\Str;

class Media
{
    /**
     * Resolve a stored image value (full URL, public path or
     * public-disk path) into an absolute URL.
     */
    public static function url(?string $path, ?string $fallback = null): ?string
    {
        if (blank($path)) {
            return $fallback ? static::url($fallback) : null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        if (Str::startsWith($path, '/')) {
            return url($path);
        }

        if (Str::startsWith($path, ['storage/', 'images/'])) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }
}
