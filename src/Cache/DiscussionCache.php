<?php

namespace Chatter\Core\Cache;

use Illuminate\Support\Facades\Cache;

class DiscussionCache extends AbstractCacheManager implements CacheProviderInterface
{
    const TAG = "discussion";
}
