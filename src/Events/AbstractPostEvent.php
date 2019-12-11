<?php

namespace Chatter\Core\Events;

use Illuminate\Http\Request;
use Chatter\Core\Models\PostInterface;

abstract class AbstractPostEvent
{
    /**
     * @var PostInterface
     */
    public $post;

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(PostInterface $post)
    {
        $this->post = $post;
    }
}
