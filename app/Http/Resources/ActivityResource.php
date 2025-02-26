<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'description' => $this->description,
            'created_at'  => $this->created_at,
            'properties'  => $this->properties,
            'causer_id'   => $this->causer_id,
            'subject_id'  => $this->subject_id,
        ];
    }
}
