<?php

namespace Chatter\Core\Events;

use Chatter\Core\Models\ReactionInterface;

abstract class AbstractReactionEvent
{
    /**
     * @var ReactionInterface
     */
    public $reaction;

    /**
     * Constructor.
     *
     * @param ReactionInterface   $reaction
     */
    public function __construct(ReactionInterface $reaction)
    {
        $this->reaction = $reaction;
    }
}
