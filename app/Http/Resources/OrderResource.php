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
            'user_image' => $this->user->image ? url('storage/' . $this->user->image) : null,
            'post_user_name' => $this->post->user->name,
            'post_user_image' => $this->post->user->image ? url('storage/' . $this->post->user->image) : null,
            'post_title' => $this->post->title,
            'body' => $this->post->body,
            'post_id' => $this->post_id,
            'status' => $this->status,
            'price' => $this->post->price,
            'chats' => $this->chats,
            'reviews' => ReviewResource::collection($this->reviews),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
