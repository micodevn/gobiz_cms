<?php

namespace Modules\Curriculum\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Http\Request;
use Modules\Curriculum\Http\Requests\CreateActivityRequest;

use Modules\Curriculum\Http\Requests\UpdateActivityRequest;

use Modules\Curriculum\Repositories\Activity\ActivityRepository;

use Modules\Curriculum\Repositories\Part\PartRepository;
use Modules\Curriculum\Services\Activity\ActivityService;

class ActivityController extends AppBaseController
{
//    /** @var ActivityRepository $activityRepository*/
    private ActivityRepository $activityRepository;

//    private $partRepository;
    private PartRepository $partRepository;
    private ActivityService $activityService;

    public function __construct(ActivityService $activityService, ActivityRepository $activityRepository, PartRepository $partRepository)
    {
        $this->activityRepository = $activityRepository;
        $this->partRepository = $partRepository;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the Part.
     */
    public function index(Request $request)
    {
        $activities = $this->activityRepository->search(['name' => ['like', $request->name]])->orderBy('updated_at','DESC')->paginate(10);
//        $parts = $this->partRepository->baseQuery()->orderBy('updated_at')->get()->pluck('name', 'id');

        return view('curriculum::pages.activities.index')
            ->with(['activities' => $activities]);
    }

    /**
     * Show the form for creating a new Part.
     */
    public function create()
    {
        $parts = $this->partRepository->baseQuery()->get()->pluck('name', 'id');
//        dd($units);

        return view('curriculum::pages.activities.create')->with('parts', $parts);
    }

    /**
     * Store a newly created Part in storage.
     */
    public function store(CreateActivityRequest $request)
    {
        $data = $request->validated();
        $part = $this->activityService->store($data);
        Flash::success('Activity saved successfully !');
        return redirect(route('activities.index'));
    }

    /**
     * Display the specified Part.
     */
//    public function show($id)
//    {
//        $part = $this->activityRepository->find($id);
//
//        if (empty($part)) {
//            Flash::error('Part not found');
//
//            return redirect(route('curriculum::pages.parts.index'));
//        }
//
//        return view('curriculum::pages.parts.show')->with('part', $part);
//    }

    /**
     * Show the form for editing the specified Part.
     */
    public function edit($id)
    {
        $activity = $this->activityRepository->find($id);

        if (empty($activity)) {
            Flash::error('Activity not found');

            return redirect(route('activities.index'));
        }

        $parts = $this->partRepository->baseQuery()->get()->pluck('name', 'id');


        return view('curriculum::pages.activities.edit')->with(['activity' => $activity, 'parts' => $parts]);
    }

    /**
     * Update the specified Part in storage.
     */
    public function update($id, UpdateActivityRequest $request)
    {
        try {
            $activity = $this->activityRepository->find($id);
            if (empty($activity)) {
                Flash::error('Activity not found');

                return redirect(route('activities.index'));
            }
            $activity = $this->activityService->update($id, $request->all());

            Flash::success('Activity updated successfully.');

            return redirect(route('activities.index'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Remove the specified Part from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $activity = $this->activityRepository->find($id);

        if (empty($part)) {
            Flash::error('Activity not found');

            return redirect(route('activities.index'));
        }

        $this->activityRepository->delete($id);

        Flash::success('Activity deleted successfully.');

        return redirect(route('activities.index'));
    }
}
