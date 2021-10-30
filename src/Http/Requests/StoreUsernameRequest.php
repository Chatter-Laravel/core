<?php

namespace Chatter\Core\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreUsernameRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|min:5|max:255|unique:users|alphadash'
        ];
    }

    /**
     * Determine if the user is authorized and change username is allowed
     *  to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && config('chatter.user.allow_username_change');
    }
}
