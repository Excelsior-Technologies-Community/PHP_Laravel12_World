<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Support\Facades\Cache;

trait CacheVersioning
{
    /**
     * Build a cache key that includes a bumpable version number.
     */
    protected function cacheKey($request, string $base): string
    {
        $version = Cache::get($base . '_version', 0);

        return $base . ':' . $version . ':' . md5($request->fullUrl());
    }

    /**
     * Bump the version for the given cache bases so stale keys expire.
     * Uses Cache::forever (works on the configured database store,
     * unlike Cache::increment which is unsupported there).
     */
    protected function bumpCache(string ...$bases): void
    {
        foreach ($bases as $base) {
            Cache::forever($base . '_version', ((int) Cache::get($base . '_version', 0)) + 1);
        }
    }
}
