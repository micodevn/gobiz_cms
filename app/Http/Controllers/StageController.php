<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStageRequest;
use App\Http\Requests\UpdateStageRequest;
use App\Repositories\StageRepository;
use Flash;
use Illuminate\Http\Request;
use Modules\Curriculum\Repositories\Level\LevelRepository;

class StageController extends AppBaseController
{
    /** @var StageRepository $stageRepository*/
    private $stageRepository;

    private $courseRepository;

    public function __construct(StageRepository $stageRepo, LevelRepository $courseRepo)
    {
        $this->stageRepository = $stageRepo;
        $this->courseRepository = $courseRepo;
    }

    /**
     * Display a listing of the Stage.
     */
    public function index(Request $request)
    {
        $stages = $this->stageRepository->paginate(10);
        $courses = $this->courseRepository->baseQuery()->get()->pluck('title', 'id');

        return view('stages.index')
            ->with(['stages' => $stages, 'courses' => $courses]);
    }

    /**
     * Show the form for creating a new Stage.
     */
    public function create()
    {
        $courses = $this->courseRepository->baseQuery()->get()->pluck('title', 'id');

        return view('stages.create')->with('courses', $courses);
    }

    /**
     * Store a newly created Stage in storage.
     */
    public function store(CreateStageRequest $request)
    {
        $input = $request->all();

        $stage = $this->stageRepository->create($input);

        Flash::success('Stage saved successfully.');

        return redirect(route('stages.index'));
    }

    /**
     * Display the specified Stage.
     */
//    public function show($id)
//    {
//        $stage = $this->stageRepository->find($id);
//
//        if (empty($stage)) {
//            Flash::error('Stage not found');
//
//            return redirect(route('stages.index'));
//        }
//
//        return view('stages.show')->with('stage', $stage);
//    }

    /**
     * Show the form for editing the specified Stage.
     */
    public function edit($id)
    {
        $stage = $this->stageRepository->find($id);

        if (empty($stage)) {
            Flash::error('Stage not found');

            return redirect(route('stages.index'));
        }

        $courses = $this->courseRepository->baseQuery()->get()->pluck('title', 'id');

        return view('stages.edit')->with(['stage' => $stage, 'courses' => $courses]);
    }

    /**
     * Update the specified Stage in storage.
     */
    public function update($id, UpdateStageRequest $request)
    {
        $stage = $this->stageRepository->find($id);

        if (empty($stage)) {
            Flash::error('Stage not found');

            return redirect(route('stages.index'));
        }

        $stage = $this->stageRepository->update($request->all(), $id);

        Flash::success('Stage updated successfully.');

        return redirect(route('stages.index'));
    }

    /**
     * Remove the specified Stage from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $stage = $this->stageRepository->find($id);

        if (empty($stage)) {
            Flash::error('Stage not found');

            return redirect(route('stages.index'));
        }

        $this->stageRepository->delete($id);

        Flash::success('Stage deleted successfully.');

        return redirect(route('stages.index'));
    }
}
