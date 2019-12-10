<?php

namespace Chatter\Core\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class AbstractDiscussionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            return Auth::user()->canDiscuss();
        }

        return false;
    }
}
