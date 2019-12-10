<?php

namespace Chatter\Core\Events;

use Illuminate\Http\Request;
use Chatter\Core\Models\PostInterface;

class AfterNewResponse
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
    public function __construct(Request $request, $post)
    {
        $this->request = $request;

        $this->post = $post;
    }
}
