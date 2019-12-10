<?php

namespace Chatter\Core\Listeners;

use Mail;
use Chatter\Core\Mail\PostUpdated;
use Chatter\Core\Events\PostEvents;
use Chatter\Core\Events\AfterNewPost;

class EmailSubscriber
{
    /**
     * Handle the event.
     *
     * @param  AfterNewPost  $event
     * @return void
     */
    public function onPostCreated(AfterNewPost $event)
    {
        if (! config('chatter.email.enabled')) {
            return;
        }

        $post = $event->post;
        $discussion = $post->discussion;
        
        foreach ($discussion->users as $user) {
            Mail::to($user)->send(new PostUpdated($discussion, $post));
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            PostEvents::POST_CREATE,
            'Chatter\Core\Listeners\EmailSubscriber@onPostCreated'
        );
    }
}
