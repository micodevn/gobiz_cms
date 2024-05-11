<?php

namespace Modules\Curriculum\Services\Level;

use Modules\Curriculum\Repositories\Level\LevelRepository;

class LevelService
{
    private LevelRepository $levelRepository;

    public function __construct(LevelRepository $levelRepository)
    {
        $this->levelRepository = $levelRepository;
    }

    public function store($value)
    {
        try {
            // validate duplicate lesson
            //week //program_type //lesson_ids //position
            $courseNew = $this->levelRepository->create($value);
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
        $course = $this->levelRepository->find($id);
        if (empty($course)) {
            return false;
        }
        $course = $this->levelRepository->update($value, $id);
        if ($course) {
            return true;
        }
        return false;
    }
}
