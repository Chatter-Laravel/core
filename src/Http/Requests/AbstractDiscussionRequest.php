<?php

namespace Chatter\Core\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Chatter\Core\Http\Requests\AbstractDiscussionRequest;

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

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException(__('chatter::alert.danger.reason.prevent_spam', [
            'seconds' => Auth::user()->seconds_until_next_question
        ]));
    }
}
