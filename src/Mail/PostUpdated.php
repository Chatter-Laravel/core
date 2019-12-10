<?php

namespace Chatter\Core\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Chatter\Core\Models\PostInterface;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Chatter\Core\Models\DiscussionInterface;

class PostUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var DiscussionInterface $discussion
     */
    public $discussion;

    /**
     * @var PostInterface $post
     */
    public $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        DiscussionInterface $discussion,
        PostInterface $post
    ) {
        $this->discussion = $discussion;
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('chatter::emails.post_update')
            ->subject(__('chatter::email.post_update.subject'))
            ->with([
                'discussion' => $this->discussion,
                'post' => $this->post,
            ]);
    }
}
