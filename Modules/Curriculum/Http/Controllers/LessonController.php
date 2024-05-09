<?php

namespace Modules\Curriculum\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Repositories\StageRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Modules\Curriculum\Http\Requests\CreateLessonRequest;
use Modules\Curriculum\Http\Requests\UpdateLessonRequest;
use Modules\Curriculum\Repositories\Lesson\LessonRepository;
use Modules\Curriculum\Services\Lesson\LessonService;

class LessonController extends AppBaseController
{
    private LessonRepository $lessonRepository;
    private StageRepository $stageRepository;
    private LessonService $lessonService;

    public function __construct(LessonService $lessonService, LessonRepository $lessonRepo, StageRepository $stageRepo)
    {
        $this->lessonRepository = $lessonRepo;
        $this->stageRepository = $stageRepo;
        $this->lessonService = $lessonService;
    }

    /**
     * Display a listing of the Lesson.
     */
    public function index(Request $request)
    {
        $lessons = $this->lessonRepository->search(['title' => ['like', $request->name]])->orderBy('updated_at')->paginate(10);
        $stages = $this->stageRepository->baseQuery()->orderBy('updated_at')->get()->pluck('title', 'id');

        return view('curriculum::pages.lessons.index')
            ->with(['lessons' => $lessons, 'stages' => $stages]);
    }

    /**
     * Show the form for creating a new Lesson.
     */
    public function create()
    {
        $stages = $this->stageRepository->baseQuery()->get()->pluck('title', 'id');
        return view('curriculum::pages.lessons.create')->with('stages', $stages);
    }

    /**
     * Store a newly created Lesson in storage.
     */
    public function store(CreateLessonRequest $request)
    {
        $input = $request->all();
        $input['part_id'] = array_merge($request->get('part_practice'), $request->get('part_homework'), $request->get('part_question'), $request->get('part_quiz'), $request->get('part_interaction'));

        $lesson = $this->lessonService->store($input);

        Flash::success('Lesson saved successfully.');

        return redirect(route('lessons.index'));
    }

    /**
     * Display the specified Lesson.
     */
//    public function show($id)
//    {
//        $lesson = $this->lessonRepository->find($id);
//
//        if (empty($lesson)) {
//            Flash::error('Lesson not found');
//
//            return redirect(route('lessons.index'));
//        }
//
//        return view('curriculum::pages.lessons.show')->with('lesson', $lesson);
//    }

    /**
     * Show the form for editing the specified Lesson.
     */
    public function edit($id)
    {
        $lesson = $this->lessonRepository->with(['parts', 'files'])->find($id);
        if (empty($lesson)) {
            Flash::error('Lesson not found');

            return redirect(route('lessons.index'));
        }

        $stages = $this->stageRepository->baseQuery()->get()->pluck('title', 'id');
        return view('curriculum::pages.lessons.edit')->with(['lesson' => $lesson, 'stages' => $stages]);
    }

    /**
     * Update the specified Lesson in storage.
     */
    public function update($id, Request $request)
    {
        try {
            // validate
            $request['part_id'] = array_merge($request->get('part_practice'), $request->get('part_homework'), $request->get('part_question'), $request->get('part_quiz'), $request->get('part_interaction'));
            $lesson = $this->lessonService->update($id, $request->all());
            Flash::success('Lesson updated successfully.');

            return redirect(route('lessons.index'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Remove the specified Lesson from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $lesson = $this->lessonRepository->find($id);

        if (empty($lesson)) {
            Flash::error('Lesson not found');

            return redirect(route('lessons.index'));
        }

        $this->lessonRepository->delete($id);
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'DELETE',
            'eventName' => 'k12_lesson',
            'data' => $lesson->id
        ]));
        Flash::success('Lesson deleted successfully.');

        return redirect(route('lessons.index'));
    }
}
