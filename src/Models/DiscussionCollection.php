<?php

namespace Chatter\Core\Models;

use Chatter\Core\Models\CategoryResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DiscussionCollection extends ResourceCollection
{
    public $category;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => DiscussionResource::collection($this->collection),
            'category' => $this->getCategory()
        ];
    }

    private function getCategory()
    {
        if (null !== $this->category) {
            return new CategoryResource($this->category);
        }

        return [
            "name" => config('chatter.title'),
            "subtitle" => config('chatter.subtitle'),
            "color" => config('chatter.color')
        ];
    }
}
