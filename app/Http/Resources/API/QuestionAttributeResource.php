<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionAttributeResource extends JsonResource
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
            'id' => \Arr::get($this, 'id'),
            'question_id' => \Arr::get($this, 'question_id'),
            'group_parent' => \Arr::get($this, 'attribute'),
            'value' => \Arr::get($this, 'value')
        ];
    }
}
