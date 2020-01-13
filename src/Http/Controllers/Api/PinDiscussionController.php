<?php

namespace Chatter\Core\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Chatter\Core\Models\Discussion;
use Chatter\Core\Models\DiscussionResource;

class PinDiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        if (null !== $id) {
            $discussion = Discussion::findOrFail($id);

            $discussion->update([
                'pinned' => !$discussion->pinned
            ]);

            return new DiscussionResource($discussion);
        }

        abort(404, printf('Discussion with id %s not found', $id));
    }
}
