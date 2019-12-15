<?php

namespace Chatter\Core\Http\Requests;

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
            'username' => 'required|min:5|max:255|unique:users'
        ];
    }
}
