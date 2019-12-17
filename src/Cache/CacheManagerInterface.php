<?php

namespace Chatter\Core\Cache;

use Illuminate\Support\Facades\Cache;

interface CacheManagerInterface
{
    public function instance(): Cache;

    public function flush(): void;
}
