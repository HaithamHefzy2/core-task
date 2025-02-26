<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'content'      => $this->content,
            'status'       => $this->status,
            'published_at' => $this->published_at,
            'user'         => new UserResource($this->user),
            'categories'   => CategoryResource::collection($this->categories),
            'created_at'   => $this->created_at,
        ];
    }
}
