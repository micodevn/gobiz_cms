<?php

namespace App\Http\Resources\API;

use App\Http\Resources\API\Traits\UsePagination;
use App\Http\Resources\SimpleQuestionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionResourceCollection extends ResourceCollection
{
    use UsePagination;

    public $collects = SimpleQuestionResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'questions' => $this->collect(),
            'pagination' => $this->pagination
        ];
    }
}
