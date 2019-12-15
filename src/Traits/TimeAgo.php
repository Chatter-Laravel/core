<?php

namespace Chatter\Core\Traits;

trait TimeAgo
{
    /**
     * Returns the created at in a human
     * readable format
     *
     * @return string
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}