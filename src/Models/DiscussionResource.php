<?php

namespace Chatter\Core\Models;

use Str;
use Chatter\Core\Models\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscussionResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'color' => $this->color,
            'views' => $this->views,
            'answered' => $this->answered,
            'answers' => $this->answers,
            'category' => new CategoryResource($this->category),
            'content' => $this->body,
            'user' => new UserResource($this->user),
            'post' => new PostResource($this->posts()->first()),
            'time_ago' => $this->time_ago,
            'last_replay' => $this->answered ? new PostResource($this->last_replay) : null,
        ];
    }
}
