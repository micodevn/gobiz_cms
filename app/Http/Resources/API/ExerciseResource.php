<?php

namespace App\Http\Resources\API;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $questionArr = [];
        $questions = $this->questions()
            ->select("*")
            ->with([
                'platform',
                'platform.parent',
                'targetLanguages',
            ])->orderBy('id', 'asc')->get();

        if ($questions) {
            $questions = $questions->sortBy('pivot.position');
        }

        foreach ($questions as $question) {
            $questionArr[] = QuestionResource::make($question)->toArray($request);
        }

        $leaningObj = $this->learningObjectives()->select('*')->with([
            'skillVerb',
            'learningGoal',
            'learningConditional',
        ])->get();
        // TODO set topic
//        $topicIds = $this->topics->pluck('topic_id') ?? [];

        $learningObjs = [];
        foreach ($leaningObj as $val) {
            $learningObjs[] = [
                'id' => $val['id'],
                'code' => $val['code'],
                'explain' => $val['explain'],
                'detail_explain' => [
                    'verb' => $val->skillVerb,
                    'goal' => $val->learningGoal,
                    'conditional' => $val->learningConditional,
                ]
            ];
        }

        $videoPath = $this->videoPath;
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "type_code" => $this->type?->code,
            "type" => $this->type,
            "platform_code" => $this->platform && $this->platform->parent ? $this->platform->parent->code : null,
            "template_code" => $this->platform ? $this->platform->code : null,
            "position" => $this->position,
            "duration" => $this->duration,
            "durationShow" => $this->duration_show,
            "questions" => $questionArr,
//            "course" => $this->course,
//            "platformImage" => $this->platformImage,
//            "semester" => $this->semester,
            "image" => $this->image_url,
            "audio" => $this->audio_url,
//            "app_image" => $this->app_image_url,
            "video" => $this->video ? File::find($this->video) : null,
//            "sub_description" => $this->sub_description,
            "platform_id" => $this->platform_id,
//            "lesson_id" => $this->lesson_id,
//            "max_attemps_allowed" => $this->max_attemps_allowed,
//            "product_id" => $this->product_id,
//            "unit" => $this->unit,
//            "user_exercise_history_summary" => [],
//            "topic_id" => $topicIds,
//            "exerciseDetail" => $this->exerciseDetail,
            'learningObj' => $learningObjs,
//            'questionsLevel' => $this->exerciseDetail ?? null
        ];
    }
}
