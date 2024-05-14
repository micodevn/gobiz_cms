<?php

namespace Modules\Curriculum\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Http\Request;
use Modules\Curriculum\Http\Requests\UpdateUnitRequest;
use Modules\Curriculum\Repositories\Level\LevelRepository;
use Modules\Curriculum\Repositories\Unit\UnitRepository;
use Modules\Curriculum\Services\Unit\UnitService;

class UnitController extends AppBaseController
{
    private UnitRepository $unitRepository;
    private LevelRepository $levelRepository;

    public function __construct(
        UnitService     $unitService,
        UnitRepository   $unitRepository,
        LevelRepository $levelRepository,
    )
    {
        $this->unitRepository = $unitRepository;
        $this->unitService = $unitService;
        $this->levelRepository = $levelRepository;
    }

    /**
     * Display a listing of the Course.
     */
    public function index(Request $request)
    {
        $units = $this->unitRepository->orderBy('updated_at','DESC')->paginate(10);

        return view('curriculum::pages.units.index')
            ->with(['units' => $units]);
    }

    /**
     * Show the form for creating a new Course.
     */
    public function create()
    {
        $levels = $this->levelRepository->baseQuery()->get()->pluck('title', 'id');

        return view('curriculum::pages.units.create', compact('levels'));
    }

    /**
     * Store a newly created Course in storage.
     */
    public function store(UpdateUnitRequest $request)
    {
        try {
            $input = $request->all();

            $levelNew = $this->unitService->store($input);
            if ($levelNew) {
                Flash::success('Unit saved successfully.');
                return redirect(route('units.index'));
            }
            Flash::error('Unit saved failed.');
            return redirect(route('units.index'));
        }  catch (\Throwable $exception) {
            dd($exception->getMessage());
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
        $unit = $this->unitRepository->find($id);
        $levels = $this->levelRepository->baseQuery()->get()->pluck('title', 'id')->toArray();
//        dd($levels);
        if (empty($unit)) {
            Flash::error('Unit not found !');

            return redirect(route('units.index'));
        }
        return view('curriculum::pages.units.edit', compact('unit','levels'));
    }

    /**
     * Update the specified Course in storage.
     */
    public function update($id, UpdateUnitRequest $request)
    {
        try {
            // Transform data
            $level = $this->unitService->update($id, $request->all());
            if ($level) {
                Flash::success('Unit updated successfully.');
                return redirect(route('units.index'));
            }
            Flash::success('Unit update Failed.');
            return redirect(route('units.index'));
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
        $level = $this->unitRepository->find($id);

        if (empty($level)) {
            Flash::error('Unit not found');

            return redirect(route('units.index'));
        }

        $this->unitRepository->delete($id);
        Flash::success('Unit deleted successfully.');

        return redirect(route('units.index'));
    }
}
