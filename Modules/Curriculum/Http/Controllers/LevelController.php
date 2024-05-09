<?php

namespace Modules\Curriculum\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Http\Request;
use Modules\Curriculum\Http\Requests\CreateCourseRequest;
use Modules\Curriculum\Http\Requests\UpdateCourseRequest;
use Modules\Curriculum\Repositories\Level\UnitRepository;
use Modules\Curriculum\Services\Level\LevelService;

class LevelController extends AppBaseController
{
    private UnitRepository $levelRepository;

    public function __construct(
        LevelService   $levelService,
        UnitRepository $levelRepository,
    )
    {
        $this->levelRepository = $levelRepository;
        $this->levelService = $levelService;
    }

    /**
     * Display a listing of the Course.
     */
    public function index(Request $request)
    {
        $levels = $this->levelRepository->orderBy('updated_at','DESC')->paginate(10);

        return view('curriculum::pages.levels.index')
            ->with(['levels' => $levels]);
    }

    /**
     * Show the form for creating a new Course.
     */
    public function create()
    {
        return view('curriculum::pages.levels.create');
    }

    /**
     * Store a newly created Course in storage.
     */
    public function store(CreateCourseRequest $request)
    {
        try {
            $input = $request->all();
            $levelNew = $this->levelService->store($input);
            if ($levelNew) {
                Flash::success('Level saved successfully.');
                return redirect(route('levels.index'));
            }
            Flash::error('Level saved failed.');
            return redirect(route('levels.index'));
        }  catch (\Throwable $exception) {
            return redirect()->back()->with('message-error', $exception->getMessage());
        }

    }

    /**
     * Display the specified Course.
     */
//    public function show($id)
//    {
//        $course = $this->courseRepository->find($id);
//
//        if (empty($course)) {
//            Flash::error('Course not found');
//
//            return redirect(route('courses.index'));
//        }
//
//        return view('curriculum::pages.levels.show')->with('course', $course);
//    }

    /**
     * Show the form for editing the specified Course.
     */
    public function edit($id)
    {
        $level = $this->levelRepository->find($id);

        if (empty($level)) {
            Flash::error('Level not found !');

            return redirect(route('levels.index'));
        }
        return view('curriculum::pages.levels.edit', compact('level'));
    }

    /**
     * Update the specified Course in storage.
     */
    public function update($id, UpdateCourseRequest $request)
    {
        try {
            // Transform data
            $level = $this->levelService->update($id, $request->all());
            if ($level) {
                Flash::success('Level updated successfully.');
                return redirect(route('levels.index'));
            }
            Flash::success('Level update Failed.');
            return redirect(route('levels.index'));
        } catch (\Throwable $exception) {
            dd($exception);
            return redirect()->back()->with('message-error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified Course from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $level = $this->levelRepository->find($id);

        if (empty($level)) {
            Flash::error('Level not found');

            return redirect(route('levels.index'));
        }

        $this->levelRepository->delete($id);
        Flash::success('Level deleted successfully.');

        return redirect(route('levels.index'));
    }
}
