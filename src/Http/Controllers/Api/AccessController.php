<?php

namespace Chatter\Core\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Chatter\Core\Http\Requests\AbstractDiscussionRequest;

class AccessController extends Controller
{
    public function canDiscuss(Request $request)
    {
        return response()->json([
            'success' => AbstractDiscussionRequest::createFrom($request)->authorize(),
            'error' => __('chatter::alert.danger.reason.prevent_spam', [
                'seconds' => Auth::user()->seconds_until_next_question
            ])
        ]);
    }
}
