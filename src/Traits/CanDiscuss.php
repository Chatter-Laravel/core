<?php

namespace Chatter\Core\Traits;

use Chatter\Core\Models\Post;
use Chatter\Core\Models\Discussion;

trait CanDiscuss
{
    /**
     * Check if the user can discuss
     *
     * @return boolean
     */
    public function canDiscuss(): bool
    {
        $past = now()->subSeconds(config('chatter.security.time_between_posts'));
        if (Discussion::where('user_id', '=', $this->id)->where('created_at', '>=', $past)->get()->isEmpty()) {
            return true;
        }
        
        return false;
    }

    public function getSecondsUntilNextQuestionAttribute(): ?string
    {
        $past = now()->subSeconds(config('chatter.security.time_between_posts'));

        $discussion = Discussion::where('user_id', '=', $this->id)
            ->where('created_at', '>=', $past)
            ->first()
        ;

        $post = Post::where('user_id', '=', $this->id) ->where('created_at', '>=', $past)
            ->orderBy('created_at', 'desc')
            ->first()
        ;
        
        if (null !== $discussion) {
            return  config('chatter.security.time_between_posts') - $discussion->created_at->diffInSeconds(now());
        }

        return null;
    }

    /**
     * Returns the visible name for a forum user
     *
     * @return string
     */
    public function getForumVisibleNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Returns the url of the avatar for each forum user
     *
     * @return string
     */
    public function getForumAvatarAttribute(): string
    {
        return 'https://eu.ui-avatars.com/api/?name=' . $this->name;
    }
}
