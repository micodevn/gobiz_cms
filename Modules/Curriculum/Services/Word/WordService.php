<?php

namespace Modules\Curriculum\Services\Word;

use Modules\Curriculum\Repositories\Word\WordRepository;

class WordService
{
    private WordRepository $wordRepository;

    public function __construct(WordRepository $wordRepository)
    {
        $this->wordRepository = $wordRepository;
    }

    public function store($value)
    {
        try {
            // validate duplicate lesson
            //week //program_type //lesson_ids //position
            $courseNew = $this->wordRepository->create($value);
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
        $course = $this->wordRepository->find($id);
        if (empty($course)) {
            return false;
        }
        $course = $this->wordRepository->update($value, $id);
        if ($course) {
            return true;
        }
        return false;
    }
}
