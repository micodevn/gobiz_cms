<?php

namespace Modules\Curriculum\Services\Activity;


//use App\Events\ChangeCurriculumProcessed;
use App\Repositories\ExerciseRepository;
use Modules\Curriculum\Repositories\Activity\ActivityRepository;

class ActivityService
{
    private ActivityRepository $activityRepository;
    private ExerciseRepository $exerciseRepository;

    public function __construct(ActivityRepository $activityRepository, ExerciseRepository $exerciseRepository)
    {
        $this->activityRepository = $activityRepository;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store($value)
    {
        try {
            $part = $this->activityRepository->create($value);
//            $this->syncExerciseRelation($part->id, $value['exercise_id']);
//            ChangeCurriculumProcessed::dispatch('INSERT', 'k12_part',  $part->id);
            return $part;
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return false;
        }
    }

    public function update($id, $value) {
        try {
            $lesson = $this->activityRepository->find($id);
            if (empty($lesson)) {
                \Flash::error('Activity not found');
                return redirect(route('parts.index'));
            }
            $part = $this->activityRepository->update($value, $id);
//            $this->syncExerciseRelation($part->id, $value['exercise_id']);
//            ChangeCurriculumProcessed::dispatch('UPDATE', 'k12_part',  $part->id);
            return $part;
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return false;
        }
    }

    private function syncExerciseRelation($partId, $exerciseIds): void
    {
        $exerciseIds = array_filter($exerciseIds);
        $this->exerciseRepository->baseQuery()->where('part_id', $partId)->update(['part_id' => null]);
        foreach ($exerciseIds as $exerciseIndex => $exerciseId) {
            $this->exerciseRepository->baseQuery()->where('id', $exerciseId)->update(['part_id' => $partId, 'position' => $exerciseIndex]);
        }
//        $this->exerciseRepository->baseQuery()->whereIn('id', $exerciseIds)->update(['part_id' => $partId]);
    }
}
