<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'user_id' => $this->user_id,
            'user' => $this->user->name,
            'userImage' => $this->user->image ? url('storage/' . $this->user->image) : null,
            'body' => $this->body,
            'price' => $this->price,
            'images' => $this->images->map(function ($image) {
                return [
                    'url' => $image->url,
                ];
            }),
            'reviews' => ReviewResource::collection($this->approvedReviews),
            'overalReview' => $this->overalReview(),
            'category_id' => $this->category_id,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
