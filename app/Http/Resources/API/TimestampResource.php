<?php

namespace App\Http\Resources\API;

use App\Models\Question;
use App\Models\VideoTimeProperty;
use Illuminate\Http\Resources\Json\JsonResource;

class TimestampResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = $this->resource;

        if ($resource instanceof VideoTimeProperty) {
            $questions = $resource->timestampQuestionsFull;
        } else {
            $questionArr = \Arr::get($this, 'timestamp_questions_full', []);
            $questions = collect();
            foreach ($questionArr as $q) {
                $question = new Question($q);

                $questions->add($question);
            }
        }

        return [
            'start' => \Arr::get($this, 'start'),
            'end' => \Arr::get($this, 'end'),
            'icon_url' => \Arr::get($this, 'icon.url'),
            'description' => \Arr::get($this, 'description'),
            'title' => \Arr::get($this, 'title'),
            'is_left' => \Arr::get($this, 'is_left'),
            'questions' => QuestionResource::collection($questions)
        ];
    }
}
