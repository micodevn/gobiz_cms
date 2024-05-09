<?php

namespace Modules\Curriculum\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Modules\Curriculum\Entities\ScheduleSlot;
use Modules\Curriculum\Http\Requests\CreateScheduleRequest;
use Modules\Curriculum\Http\Requests\UpdateScheduleRequest;
use Modules\Curriculum\Repositories\Level\UnitRepository;
use Modules\Curriculum\Repositories\Schedule\ScheduleRepository;
use Modules\Curriculum\Repositories\Schedule\TimeSlotRepository;

class ScheduleController extends AppBaseController
{
    /** @var ScheduleRepository $scheduleRepository*/
    private $scheduleRepository;

    private $courseRepository;
    private $timeSlotRepository;

    public function __construct(ScheduleRepository $scheduleRepo, UnitRepository $courseRepo, TimeSlotRepository $timeSlotRepository)
    {
        $this->scheduleRepository = $scheduleRepo;
        $this->courseRepository = $courseRepo;
        $this->timeSlotRepository = $timeSlotRepository;
    }

    /**
     * Display a listing of the Schedule.
     */
    public function index(Request $request)
    {
        $schedules = $this->scheduleRepository->paginate(10);
        $courses = $this->courseRepository->baseQuery()->get()->pluck('title', 'id');

        return view('schedules.index')
            ->with(['schedules' => $schedules, 'courses' => $courses]);
    }

    /**
     * Show the form for creating a new Schedule.
     */
    public function create()
    {
        $courses = $this->courseRepository->baseQuery()->get()->pluck('title', 'id');
        $schedules = $this->scheduleRepository->with('timeSlots')->all();
        $timeSlots = $this->timeSlotRepository->all();
        return view('schedules.create', ['schedules' => $schedules, 'courses' => $courses, 'timeSlots' => $timeSlots]);
    }

    /**
     * Store a newly created Schedule in storage.
     */
    public function store(CreateScheduleRequest $request)
    {
        try {
            $input = $request->validated();
            $schedule = $this->scheduleRepository->create($input);

            if($input['time_slot']) {
                $data = [];
                foreach ($input['time_slot'] as $time) {
                    $data[] = [
                        'time_slot_id' => $time,
                        'schedule_id' => $schedule->id
                    ];
                }
                ScheduleSlot::query()->where('schedule_id', $schedule->id)->delete();
                ScheduleSlot::query()->insert($data);
            }
            Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
                'action' => 'INSERT',
                'eventName' => 'k12_schedule',
                'data' => $schedule->id
            ]));
            Flash::success('Schedule saved successfully.');

            return redirect(route('schedules.index'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Display the specified Schedule.
     */
//    public function show($id)
//    {
//        $schedule = $this->scheduleRepository->find($id);
//
//        if (empty($schedule)) {
//            Flash::error('Schedule not found');
//
//            return redirect(route('schedules.index'));
//        }
//
//        return view('schedules.show')->with('schedule', $schedule);
//    }

    /**
     * Show the form for editing the specified Schedule.
     */
    public function edit($id)
    {
        $schedule = $this->scheduleRepository->with(['timeSlots'])->find($id);
        $timeSlots = $this->timeSlotRepository->all();
        if (empty($schedule)) {
            Flash::error('Schedule not found');

            return redirect(route('schedules.index'));
        }
        $schedules = $this->scheduleRepository->all();
        $courses = $this->courseRepository->baseQuery()->get()->pluck('title', 'id');

        return view('schedules.edit')->with(['schedule' => $schedule, 'courses' => $courses, 'schedules' => $schedules, 'timeSlots' => $timeSlots]);
    }

    /**
     * Update the specified Schedule in storage.
     */
    public function update($id, UpdateScheduleRequest $request)
    {
        $schedule = $this->scheduleRepository->find($id);

        if (empty($schedule)) {
            Flash::error('Schedule not found');

            return redirect(route('schedules.index'));
        }
        $input = $request->validated();
        $schedule = $this->scheduleRepository->update($input, $id);
        if($input['time_slot']) {
            $data = [];
            foreach ($input['time_slot'] as $time) {
                $data[] = [
                    'time_slot_id' => $time,
                    'schedule_id' => $schedule->id
                ];
            }
            ScheduleSlot::query()->where('schedule_id', $schedule->id)->delete();
            ScheduleSlot::query()->insert($data);
        }
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE',
            'eventName' => 'k12_schedule',
            'data' => $schedule->id
        ]));
        Flash::success('Schedule updated successfully.');

        return redirect(route('schedules.index'));
    }

    /**
     * Remove the specified Schedule from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $schedule = $this->scheduleRepository->find($id);

        if (empty($schedule)) {
            Flash::error('Schedule not found');

            return redirect(route('schedules.index'));
        }

        $this->scheduleRepository->delete($id);
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE_ALL',
            'eventName' => 'k12_schedule',
            'data' => null
        ]));
        Flash::success('Schedule deleted successfully.');

        return redirect(route('schedules.index'));
    }
}
