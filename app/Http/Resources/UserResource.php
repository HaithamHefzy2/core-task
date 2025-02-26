<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'active'     => $this->active,
            'roles'      => $this->roles->pluck('name'),
            'permissions'=> $this->getAllPermissions()->pluck('name'),
            'created_at' => $this->created_at,
        ];
    }
}
