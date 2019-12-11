<?php

namespace Chatter\Core\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Chatter\Core\Models\Post;
use Illuminate\Routing\Controller;
use Chatter\Core\Events\PostEvents;
use Chatter\Core\Models\PostResource;
use Chatter\Core\Models\PostInterface;
use Chatter\Core\Models\PostCollection;
use Chatter\Core\Events\AfterCreatePost;
use Chatter\Core\Events\AfterUpdatePost;
use Chatter\Core\Events\BeforeCreatePost;
use Chatter\Core\Events\BeforeUpdatePost;
use Chatter\Core\Models\DiscussionInterface;
use Chatter\Core\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except(['index', 'show'])
        ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('discussion')) {
            $discussion = model(DiscussionInterface::class)::where('slug', $request->discussion)->first();

            return new PostCollection($discussion->posts()
                ->orderBy('created_at')
                ->paginate(config('chatter.paginate.discussions')));
        }

        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = model_instance(PostInterface::class);
        $post->fill($request->all());
        $post->user_id = Auth::user()->id;
        
        event(PostEvents::PRE_CREATE, new BeforeCreatePost($post));
        $post->save();
        event(PostEvents::POST_CREATE, new AfterCreatePost($post));

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PostResource(Post::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user->id !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $post->fill($request->all());
        
        event(PostEvents::PRE_UPDATE, new BeforeUpdatePost($post));
        $post->save();
        event(PostEvents::POST_UPDATE, new AfterUpdatePost($post));

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
