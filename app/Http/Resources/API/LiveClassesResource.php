<?php

namespace App\Http\Resources\API;

use App\Helpers\Helper;
use App\Models\Question;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\Collection;

class LiveClassesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name ?? '',
            "description" => $this->description ?? '',
            "image_path" => !empty($this->imagePath->id) ? $this->resolveUrlFile($this->imagePath->id, 'imagePath') : "",
            "video_path" => !empty($this->videoPath->id) ? $this->resolveUrlFile($this->videoPath->id, 'videoPath') : "",
            "video_path2" => !empty($this->videoPath2->id) ? $this->resolveUrlFile($this->videoPath2->id, 'videoPath2') : "",
            "start_time_1st" => $this->start_time_1st ? Helper::format_date($this->start_time_1st) : '',
            "end_time_1st" => $this->end_time_1st ? Helper::format_date($this->end_time_1st) : '',
            "start_time_2nd" => $this->start_time_2nd ? Helper::format_date($this->start_time_2nd) : '',
            "end_time_2nd" => $this->end_time_2nd ? Helper::format_date($this->end_time_2nd) : '',
            "course" => $this->course ?? '',
            "type" => $this->type ?? '',
            "num_react" => $this->num_react ?? 0,
            'questions' => QuestionResource::collection($this->questions)
        ];

    }
}
