<?php

namespace Chatter\Core\Listeners;

use Auth;
use Mail;
use Chatter\Core\Mail\PostUpdated;
use Chatter\Core\Events\PostEvents;
use Chatter\Core\Events\AfterCreatePost;

class EmailSubscriber
{
    /**
     * Handle the event.
     *
     * @param  AfterCreatePost  $event
     * @return void
     */
    public function onPostCreated(AfterCreatePost $event)
    {
        if (! config('chatter.email.enabled')) {
            return;
        }

        $email = Auth::user()->email;
        $post = $event->post;
        $discussion = $post->discussion;
        
        foreach ($discussion->users as $user) {
            if ($user->email !== $email) {
                Mail::to($user)->send(new PostUpdated($discussion, $post));
            }
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
