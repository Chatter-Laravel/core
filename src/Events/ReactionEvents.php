<?php

namespace Chatter\Core\Events;

class ReactionEvents
{
    const PRE_CREATE = 'chatter.reaction.pre_create';
    const POST_CREATE = 'chatter.reaction.post_create';
    const PRE_DELETE = 'chatter.reaction.pre_delete';
    const POST_DELETE = 'chatter.reaction.post_delete';
}
