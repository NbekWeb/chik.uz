<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymeTransactionResource extends JsonResource
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
            'time' => $this->payme_time,
            'amount' => $this->amount,
            'account' => [
                'user_id' => $this->owner_id
            ],
            'create_time' => $this->create_time,
            'perform_time' => $this->perform_time ?: 0,
            'cancel_time' => $this->cancel_time ?: 0,
            'transaction' => $this->transaction,
            'state' => $this->state,
            'reason' => $this->reason ?: null
        ];
    }
}
