<?php

namespace App\Repositories;

use App\Models\Exercise;
use App\Models\ExerciseAttribute;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

/**
 * Class ExerciseRepository
 * @package App\Repositories
 * @version April 5, 2022, 4:10 pm +07
 */
class ExerciseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'description',
        'lesson_id',
        'position',
        'is_active',
        'duration',
        'image',
        'created_by',
        'updated_by',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Exercise::class;
    }

    public function create(array $attributes)
    {
        $attributes['question_ids'] = array_filter($attributes['question_ids']);
//        $attributes['learningObj_id'] = array_filter($attributes['learningObj_id']);

        /** @var Exercise $exercise */
        $exercise = parent::create($attributes);

        $questions = $this->detachQuestions($attributes['question_ids']);

        $exercise->questions()->sync($questions);
        $this->syncExerciseAttribute($exercise, $attributes);
// TODO learningObjectives
//        $exercise->learningObjectives()->sync($attributes['learningObj_id']);

//        $exercise->load(['learningObjectives']);
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE',
            'eventName' => 'k12_exercise',
            'data' => $exercise->id
        ]));
        return $exercise;
    }

    public function update($attributes, $id)
    {
        $attributes['question_ids'] = array_filter($attributes['question_ids']);
//        $attributes['learningObj_id'] = array_filter($attributes['learningObj_id']);

        /** @var Exercise $exercise */

        $exercise = parent::update($attributes, $id);

        $questions = $this->detachQuestions($attributes['question_ids']);

        $exercise->questions()->sync($questions);
        $this->syncExerciseAttribute($exercise, $attributes);
// TODO learningObjectives
//        $exercise->learningObjectives()->sync($attributes['learningObj_id']);

//        $exercise->load('videoPath.videoTimestamps.timestampQuestionsFull');
//        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
//            'action' => 'UPDATE',
//            'eventName' => 'k12_exercise',
//            'data' => $exercise->id
//        ]));
        return $exercise;
    }

    protected function detachQuestions($questions): array
    {
        $questionSorted = [];
        $questions = array_filter($questions);
        if (!$questions) return [];
        foreach ($questions as $key => $question) {
            $questionSorted[$question] = [
                'position' => $key
            ];
        }

        return $questionSorted;
    }

    public function baseQuery()
    {
        return $this->newQuery()
            ->where('deleted_at', null)
            ->orderBy('id', 'desc');
    }

    public function syncExerciseAttribute($exercise, $attributes): bool
    {
        $data = [];
        ExerciseAttribute::query()->where('exercise_id', '=', $exercise->id)->delete();
        if (!empty($attributes['questionsLevel']) && is_array($attributes['questionsLevel'])) {
            foreach ($attributes['questionsLevel'] as $val) {
                $data[] = [
                    'exercise_id' => $exercise->id,
                    'level' => Arr::get($val, 'level'),
                    'platform_id' => Arr::get($val, 'platform_id') && Arr::get($val, 'platform_id') != -1 ? Arr::get($val, 'platform_id') : null,
                    'question_number' => Arr::get($val, 'question_number'),
                    'other_platform' => Arr::get($val, 'platform_id') == -1
                ];
            }
            ExerciseAttribute::insert($data);
        }
        return true;
    }
}
