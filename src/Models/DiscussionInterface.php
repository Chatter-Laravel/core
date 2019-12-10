<?php

namespace Chatter\Core\Models;

interface DiscussionInterface
{
    public function user();

    public function category();

    public function posts();

    public function users();

    public function postsCount();

    public function getBodyAttribute();
}
