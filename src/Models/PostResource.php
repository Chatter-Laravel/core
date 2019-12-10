<?php

namespace Chatter\Core\Models;

use Str;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'time_ago' => $this->time_ago,
            'user' => [
                'username' => Str::title($this->user->forum_visible_name),
                'avatar' => $this->user->forum_avatar
            ]
        ];
    }
}
