<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'order_name' => $this->order->post->title,
            'amount' => $this->amount,
            'transaction_type' => $this->transaction_type,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
