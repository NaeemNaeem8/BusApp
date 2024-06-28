<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'image'             => $this->image ?? false,
            'card_image'        => $this->card_image ?? false,
            'register_type'     => $this->register_type,
            'university_id'     => $this->university_id,
            'university_name'   => !isset($this->university->deleted_at) ? $this->university->name : $this->university->name  . ' (تم ايقاف التوصيل لهذه الجامعة) ',
            'university_logo'   => $this->university->logo
        ];
    }
}
