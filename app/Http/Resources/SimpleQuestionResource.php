<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $templateCode = $this->platform ? $this->platform->code : '';
        $platformCode = $this->platform && $this->platform->parent ? $this->platform->parent->code : '';
        $templateName = $this->platform ? $this->platform->name : '';
        $platformName = $this->platform && $this->platform->parent ? $this->platform->parent->name : '';

        $exerciseIds = $this->exercises->pluck('id');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'platform_code' => intval($platformCode),
            'template_code' => intval($templateCode),
            'platform_name' => $platformName,
            'template_name' => $templateName,
            'exercise_ids' => $exerciseIds->toArray(),
            'thumbnail' => $this->thumbnail_url,
            'sync_id' => $this->sync_id,
            'class_id' => $this->class_id,
            'class_name' => $this->getClassName(),
            'topic_id' => $this->topic_id ?? null,
            'level' => $this->level ?? null,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
