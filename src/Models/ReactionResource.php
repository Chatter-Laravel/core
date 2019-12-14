<?php

namespace Chatter\Core\Models;

use Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ReactionResource extends JsonResource
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
            'emoji_name' => $this->emoji_name,
            'emoji' => $this->emoji,
            'count' => $this->emoji_count,
            'user_reacted' => $this->user_reacted
        ];
    }
}
