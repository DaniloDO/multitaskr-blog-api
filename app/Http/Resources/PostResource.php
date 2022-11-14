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
        $user = $request->get('user', false);

        if($user) {
            $this->load('user');
        }


        return array_merge(parent::toArray($request), [
            'user' => new UserResource($this->whenLoaded('user'))
        ]);
    }
}
