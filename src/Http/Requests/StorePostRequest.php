<?php

namespace Chatter\Core\Http\Requests;

class StorePostRequest extends AbstractDiscussionRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|min:10'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'body.required' => trans('chatter::alert.danger.reason.content_required'),
            'body.min' => trans('chatter::alert.danger.reason.content_min')
        ];
    }
}
