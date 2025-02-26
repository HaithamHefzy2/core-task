<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'content'    => $this->content,
            'user'       => new UserResource($this->whenLoaded('user')),
            'post'       => new UserResource($this->whenLoaded('post')),
            'created_at' => $this->created_at,
        ];
    }
}
