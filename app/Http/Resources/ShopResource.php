<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user' => $this->user ? $this->user->name : '',
            'user_id' => $this->user_id,
            'hour' => $this->hour,
            'address' => $this->address,
            'image' => $this->image,
            'position' => [
                'lat' => $this->latitude,
                'lng' => $this->longitude
            ] 
        ];
    }
}
