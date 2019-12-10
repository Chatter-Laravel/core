<?php

namespace Chatter\Core\Events;

use Illuminate\Http\Request;
use Chatter\Core\Models\DiscussionInterface;

class BeforeNewDiscussion
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var DiscussionInterface
     */
    public $discussion;

    /**
     * Constructor.
     *
     * @param Discussion   $discussion
     */
    public function __construct(Request $request, DiscussionInterface $discussion)
    {
        $this->request = $request;
        $this->discussion = $discussion;
    }
}
