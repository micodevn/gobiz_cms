<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'text' => TextResource::make(\Arr::get($this, 'text'))->toArray($request),
            'image' => ImageResource::make(\Arr::get($this, 'image'))->toArray($request),
            'audio' => AudioResource::make(\Arr::get($this, 'audio'))->toArray($request),
            'right_response' => \Arr::get($this, 'right_response'),
            'animation' => \Arr::get($this, 'animation')
        ];
    }
}
