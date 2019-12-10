<?php

namespace Chatter\Core\Http\Requests;

class StoreDiscussionRequest extends AbstractDiscussionRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:255',
            'body' => 'required|min:10',
            'category_id' => 'required',
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
            'title.required' =>  trans('chatter::alert.danger.reason.title_required'),
            'title.min' => [
                'string'  => trans('chatter::alert.danger.reason.title_min'),
            ],
            'title.max' => [
                'string'  => trans('chatter::alert.danger.reason.title_max'),
            ],
            'body.required' => trans('chatter::alert.danger.reason.content_required'),
            'body.min' => trans('chatter::alert.danger.reason.content_min'),
            'category_id.required' => trans('chatter::alert.danger.reason.category_required'),
        ];
    }
}
