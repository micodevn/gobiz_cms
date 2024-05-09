<?php

namespace Modules\Curriculum\Services\Lesson;


use App\Events\ChangeCurriculumProcessed;
use Illuminate\Support\Facades\Redis;
use Modules\Curriculum\Repositories\Lesson\LessonRepository;
use Modules\Curriculum\Repositories\Part\PartRepository;

class LessonService
{
    private PartRepository $partRepository;
    private LessonRepository $lessonRepository;

    public function __construct(PartRepository $partRepository, LessonRepository $lessonRepository)
    {
        $this->partRepository = $partRepository;
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store($value)
    {
        try {
            $lesson = $this->lessonRepository->create($value);
            if (isset($value['part_id'])) {
                $this->syncPartRelation($lesson, $value['part_id']);
            }
            if (isset($value['doc_id'])) {
                $this->syncFileDocRelation($lesson, $value['doc_id']);
            }
            ChangeCurriculumProcessed::dispatch('INSERT', 'k12_lesson',  $lesson->id);
            return $lesson;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function update($id, $value)
    {
        $lesson = $this->lessonRepository->update($value, $id);
        if (isset($value['part_id'])) {
            $this->syncPartRelation($lesson, $value['part_id']);
        }
        if (isset($value['doc_id'])) {
            $this->syncFileDocRelation($lesson, $value['doc_id']);
        }
        ChangeCurriculumProcessed::dispatch('UPDATE', 'k12_lesson',  $lesson->id);
        return $lesson;
    }

    private function syncPartRelation($lesson, $partIds): void
    {
        if ($partIds) {
            $partIds = array_filter($partIds);
            $this->partRepository->newQuery()->where('lesson_id', $lesson->id)->update(['lesson_id' => null]);
            $this->partRepository->newQuery()->whereIn('id', $partIds)->update(['lesson_id' => $lesson->id]);
        }

    }

    private function syncFileDocRelation($lesson, $docIds): void
    {
        if ($docIds) {
            $docIds = array_filter($docIds);
            $lesson->files()->sync($docIds);
        }
    }
}
