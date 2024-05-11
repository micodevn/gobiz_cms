<?php

namespace Modules\Curriculum\Services\Part;


use App\Events\ChangeCurriculumProcessed;
use App\Repositories\ExerciseRepository;
use Modules\Curriculum\Repositories\Part\PartRepository;

class PartService
{
    private PartRepository $partRepository;
    private ExerciseRepository $exerciseRepository;

    public function __construct(PartRepository $partRepository, ExerciseRepository $exerciseRepository)
    {
        $this->partRepository = $partRepository;
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store($value)
    {
        try {
            $part = $this->partRepository->create($value);
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
            $lesson = $this->partRepository->find($id);
            if (empty($lesson)) {
                \Flash::error('Part not found');
                return redirect(route('parts.index'));
            }
            $part = $this->partRepository->update($value, $id);
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
