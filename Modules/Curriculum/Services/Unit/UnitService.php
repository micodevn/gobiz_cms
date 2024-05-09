<?php

namespace Modules\Curriculum\Services\Unit;

use Modules\Curriculum\Repositories\Unit\UnitRepository;

class UnitService
{
    private UnitRepository $unitRepository;

    public function __construct(UnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    public function store($value)
    {
        try {
            // validate duplicate lesson
            //week //program_type //lesson_ids //position
            $courseNew = $this->unitRepository->create($value);
            if ($courseNew) {
                return true;
            }
            return false;
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return false;
        }
    }

    public function update($id, $value)
    {
        $course = $this->unitRepository->find($id);
        if (empty($course)) {
            return false;
        }
        $course = $this->unitRepository->update($value, $id);
        if ($course) {
            return true;
        }
        return false;
    }
}
