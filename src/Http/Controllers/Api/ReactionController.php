<?php

namespace Chatter\Core\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Chatter\Core\Models\Post;
use Illuminate\Routing\Controller;
use Chatter\Core\Models\Discussion;
use Chatter\Core\Models\PostResource;
use Chatter\Core\Events\ReactionEvents;
use Chatter\Core\Events\DiscussionEvents;
use Chatter\Core\Models\ReactionInterface;
use Chatter\Core\Models\DiscussionResource;
use Chatter\Core\Events\AfterCreateReaction;
use Chatter\Core\Events\AfterDeleteReaction;
use Chatter\Core\Events\BeforeCreateReaction;
use Chatter\Core\Events\BeforeDeleteReaction;
use Chatter\Core\Http\Requests\ReactionRequest;

class ReactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function toggle(ReactionRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $query = $post->reactions()
            ->where('user_id', Auth::user()->id)
            ->where('emoji', $request->emoji)
            ->where('emoji_name', $request->emoji_name);

        if ($query->exists()) {
            $reaction = $query->first();

            event(ReactionEvents::PRE_DELETE, new BeforeDeleteReaction($reaction));
            $query->delete();
            event(ReactionEvents::POST_DELETE, new AfterDeleteReaction($reaction));
        } else {
            $reaction = model_instance(ReactionInterface::class);
            $reaction->user_id = Auth::user()->id;
            $reaction->emoji = $request->emoji;
            $reaction->emoji_name = $request->emoji_name;

            event(ReactionEvents::PRE_CREATE, new BeforeCreateReaction($reaction));
            $post->reactions()->save($reaction);
            event(ReactionEvents::POST_CREATE, new AfterCreateReaction($reaction));
        }

        return response()->json(new PostResource($post));
    }
}
