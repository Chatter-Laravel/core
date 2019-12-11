<?php

namespace Chatter\Core\Traits;

use Illuminate\Support\Str;
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
        $seconds = $this->getSecondsUntilNextQuestionAttribute();
        if (null !== $seconds && $seconds > 0) {
            return false;
        }
        
        return true;
    }

    /**
     * Calculates how many seconds an logged in user has to
     * wait until it can submit the next discussion
     *
     * @return string|null
     */
    public function getSecondsUntilNextQuestionAttribute(): ?int
    {
        $timeBetweenPosts = config('chatter.security.time_between_posts', 0);

        if (0 === $timeBetweenPosts) {
            return null;
        }

        $past = now()->subSeconds($timeBetweenPosts);

        /**
         * Check if the user has created any discussion/post before the time_between_posts
         * setting
         */
        $post = Post::where('user_id', $this->id)
            ->where('created_at', '>=', $past)
            ->orderBy('created_at', 'desc')
            ->first();

        if (null !== $post) {
            return  $timeBetweenPosts - $post->created_at->diffInSeconds(now());
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
        return Str::words($this->name, 1, '');
    }

    /**
     * Returns the url of the avatar for each forum user
     *
     * @return string
     */
    public function getForumAvatarAttribute(): string
    {
        return 'https://randomuser.me/api/portraits/men/' . $this->id . '.jpg';
    }
}
