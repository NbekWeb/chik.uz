<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetUserResourceController extends JsonResource
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
            'phone' => $this->phone,
            'email' => $this->email,
            'cash' =>$this->cash,
            'status' => $this->status ? "Active" : "Deactive",
            'last_activity_at' => $this->last_activity_at,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
