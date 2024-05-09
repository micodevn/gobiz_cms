<?php

namespace App\Http\Resources\API;

use App\Helpers\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionPlatformResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $parentOptions = $this->detachAttrOptions();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'parent_id' => $this->name,
            'media_types' => $this->media_types ? explode(',',$this->media_types) : [],
            'attribute_options' => json_encode($parentOptions),
            'image' => [
                'id' => $this->image_id,
                'url' => $this->image ? $this->image->file_path_url : ''
            ],
        ];
    }
}
