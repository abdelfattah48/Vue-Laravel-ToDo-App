<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    //  Transforme l'utilisateur en tableau pour l'API
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'full_name' => $this->full_name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'address'   => $this->address,
            'image'     => $this->image,
        ];
    }
}
