<?php

namespace Chatter\Core\Models;

use Str;
use Chatter\Core\Models\ReactionResource;
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
            'reactions' => ReactionResource::collection($this->reactions()
                                ->distinct('emoji_name')
                                ->get()
                                ->unique('emoji_name')),
            'user' => new UserResource($this->user)
        ];
    }
}
