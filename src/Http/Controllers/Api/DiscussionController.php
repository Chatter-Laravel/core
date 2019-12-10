<?php

namespace Chatter\Core\Http\Controllers\Api;

use DB;
use Auth;
use Illuminate\Http\Request;
use Chatter\Core\Models\Post;
use Chatter\Core\Models\Category;
use Illuminate\Routing\Controller;
use Chatter\Core\Models\Discussion;
use Chatter\Core\Models\PostInterface;
use Chatter\Core\Events\AfterNewDiscussion;
use Chatter\Core\Models\DiscussionResource;
use Chatter\Core\Events\BeforeNewDiscussion;
use Chatter\Core\Models\DiscussionInterface;
use Chatter\Core\Models\DiscussionCollection;
use Chatter\Core\Http\Requests\StoreDiscussionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except(['index', 'show'])
        ;
    }

    /**
     * Display discussions
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();

            $collection = new DiscussionCollection($category->discussions()
                ->orderBy('created_at', 'asc')
                ->paginate(config('chatter.paginate.discussions')));

            $collection->category = $category;
            
            return $collection;
        }

        return new DiscussionCollection(Discussion::paginate(config('chatter.paginate.discussions')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiscussionRequest $request)
    {
        $user = Auth::user();

        $discussion = model_instance(DiscussionInterface::class);
        $discussion->fill($request->all());

        event(new BeforeNewDiscussion($discussion));

        $discussion->user_id = $user->id;
        $discussion->save();
        $discussion->users()->save($user);

        $post = model_instance(PostInterface::class);
        $post->fill($request->all());
        $post->user_id = $user->id;
        $discussion->posts()->save($post);

        event(new AfterNewDiscussion($discussion));

        return new DiscussionResource($discussion);
    }

    public function canStore(Request $request)
    {
        return response()->json([
            'success' => StoreDiscussionRequest::createFrom($request)->authorize(),
            'error' => __('chatter::alert.danger.reason.prevent_spam', [
                'seconds' => Auth::user()->seconds_until_next_question
            ])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discussion = Discussion::where('id', $id)
            ->orWhere('slug', $id)
            ->firstOrFail();

        $discussion->increment('views');

        return new DiscussionResource($discussion);
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
        $discussion = Discussion::findOrFail($id);
        $discussion->fill($request->all());
        $discussion->save();

        return new DiscussionResource($discussion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json([
            'deleted' => Discussion::findOrFail($id)->delete()
        ]);
    }

    public function users($slug)
    {
        $discussion = Discussion::where('slug', $slug)->first();

        if (null !== $discussion) {
            return response()->json($discussion->users()->get());
        }
        
        abort(404);
    }
}
