<?php

namespace Chatter\Core\Cache;

use Illuminate\Support\Facades\Cache;

class PostCache extends AbstractCacheManager implements CacheProviderInterface
{
    const TAG = "post";
}
