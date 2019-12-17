<?php

namespace Chatter\Core\Cache;

use Illuminate\Support\Facades\Cache;

abstract class AbstractCacheManager implements CacheProviderInterface
{
    const TAG = "discussion";

    public function instance(): Cache
    {
        return Cache::tags([self::TAG]);
    }

    public function flush(): void
    {
        Cache::tags(self::TAG)->flush();
    }
}
