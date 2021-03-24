<?php

namespace Chatter\Core\Models;

use Chatter\Core\Helpers\ChatterHelper;
use Str;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => Str::title($this->forum_visible_name),
            'avatar' => $this->forum_avatar,
            'profile_url' => ChatterHelper::userLink($this),
        ];
    }
}
