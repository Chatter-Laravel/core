<?php

namespace Chatter\Core\Traits;

use Auth;
use Chatter\Core\Models\ReactionInterface;

trait Reactionable
{
    public function reactions()
    {
        return $this->morphMany(model(ReactionInterface::class), 'reactionable');
    }
    
    public function getUserReactionsAttribute()
    {
        if (Auth::check()) {
            return $this->reactions()->where('user_id', Auth::user()->id)->get();
        }
        
        return null;
    }
}
