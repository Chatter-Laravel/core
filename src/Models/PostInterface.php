<?php

namespace Chatter\Core\Models;

interface PostInterface
{
    public function discussion();

    public function user();
}
