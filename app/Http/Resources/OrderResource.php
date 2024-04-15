<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'post_title' => $this->post->title,
            'body' => $this->post->body,
            'post_id' => $this->post_id,
            'status' => $this->status,
            'price' => $this->post->price,
            'chats' =>$this->chats,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
