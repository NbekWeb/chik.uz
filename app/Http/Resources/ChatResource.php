<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'text' => $this->text,
            'order' => new OrderResource($this->order),
            'user' => $this->user,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'userImage' => $this->user->image ? url('storage/' . $this->user->image) : null,
            'time' => $this->created_at->diffForHumans(),
        ];
    }
}
