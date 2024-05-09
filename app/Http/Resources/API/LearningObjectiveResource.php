<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class LearningObjectiveResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->code,
            "explain" => $this->explain,
            "verb" => $this?->skillVerb->name,
            "goal" => $this?->learningGoal->name,
            "conditional" => $this?->learningConditional?->name,
        ];
    }
}
