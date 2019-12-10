<?php

namespace Chatter\Core\Events;

class BeforeNewPost
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var PostInterface
     */
    public $post;

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request, PostInterface $post)
    {
        $this->request = $request;
        $this->post = $post;
    }
}
