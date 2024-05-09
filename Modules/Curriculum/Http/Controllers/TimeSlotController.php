<?php

namespace Modules\Curriculum\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Modules\Curriculum\Http\Requests\UpdateScheduleRequest;
use Modules\Curriculum\Repositories\Schedule\TimeSlotRepository;

class TimeSlotController extends AppBaseController
{
    private TimeSlotRepository $timeSlotRepository;

    public function __construct(TimeSlotRepository $timeSlotRepository)
    {
        $this->timeSlotRepository = $timeSlotRepository;
    }

    /**
     * Display a listing of the Schedule.
     */
    public function index(Request $request)
    {
        $listTimeSlot = $this->timeSlotRepository->all()->groupBy('day_of_week');
        return view('curriculum::pages.time-slots.index', compact('listTimeSlot'));
    }

    /**
     * Show the form for creating a new Schedule.
     */
    public function create()
    {
        return view('curriculum::pages.time-slots.create');
    }

    /**
     * Store a newly created Schedule in storage.
     */
    public function store(Request $request)
    {
        try {
            $dayOfWeeks = $request->get('day_of_week');
            if (count($dayOfWeeks)) {
                $startTimeValues = $request->get('start_time');
                $endTimeValues = $request->get('end_time');
                $dayOfWeekCollection = collect([]);
                foreach ($dayOfWeeks as $indexDayOfWeek => $dayOfWeek) {
                    $startTimeCollection = $dayOfWeekCollection->get($dayOfWeek);
                    if (!$startTimeCollection) {
                        $dayOfWeekCollection->put($dayOfWeek, [
                            "$startTimeValues[$indexDayOfWeek]" => [$endTimeValues[$indexDayOfWeek]],
                        ]);
                    } else {
                        if (!isset($startTimeCollection[$indexDayOfWeek])) {
                            $startTimeCollection[$startTimeValues[$indexDayOfWeek]][] = $endTimeValues[$indexDayOfWeek];
                        } else {
                            if (!in_array($endTimeValues[$indexDayOfWeek], $startTimeValues[$indexDayOfWeek])) {
                                $startTimeCollection[$startTimeCollection[$indexDayOfWeek]][] = $endTimeValues[$indexDayOfWeek];
                            }

                        }
                        $dayOfWeekCollection->put($dayOfWeek, $startTimeCollection);
                    }
                }
                if (!$dayOfWeekCollection->isEmpty()) {
                    $inputs = [];
                    foreach ($dayOfWeekCollection as $dayOfWeek => $startTimes) {
                        foreach ($startTimes as $startTime => $endTimes) {
                            foreach ($endTimes as $endTime) {
                                $inputs[] = [
                                    'day_of_week' => $dayOfWeek,
                                    'start_time' => $startTime,
                                    'end_time' => $endTime
                                ];
                            }
                        }
                    }
                    foreach ($inputs as $input) {
                        $this->timeSlotRepository->updateOrCreate($input, ['day_of_week', 'start_time', 'end_time']);
                    }
                    Flash::success('TimeSlot saved successfully.');
                    return redirect(route('time-slots.index'));
                }

            }
            Flash::success('TimeSlot create failed.');
            return redirect(route('time-slots.index'));
        } catch (\Exception $ex) {
            Flash::success('TimeSlot create failed.');
            return redirect(route('time-slots.index'));
        }
    }

    /**
     * Display the specified Schedule.
     */
//    public function show($id)
//    {
//        $schedule = $this->timeSlotRepository->find($id);
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
        $schedule = $this->timeSlotRepository->find($id);

        if (empty($schedule)) {
            Flash::error('Schedule not found');

            return redirect(route('time-slots.index'));
        }
        return view('curriculum::pages.time-slots.edit');
    }

    public function editTimeOfWeek($dayOfWeek) {
        $schedule = $this->timeSlotRepository->findWhere(['day_of_week' => $dayOfWeek]);
        if (empty($schedule)) {
            Flash::error('Schedule not found');
            return redirect(route('time-slots.index'));
        }
        return view('curriculum::pages.time-slots.edit', compact('schedule', 'dayOfWeek'));
    }

    public function updateTimeOfWeek($dayOfWeek, Request $request) {
        $schedule = $this->timeSlotRepository->findWhere(['day_of_week' => $dayOfWeek]);
        if (empty($schedule)) {
            Flash::error('Schedule not found');
            return redirect(route('schedules.index'));
        }
        $timeSlotId = $request->get('time_slot_id');
        $startTime = $request->get('start_time');
        $endTime = $request->get('end_time');
        foreach ($timeSlotId as $key => $id) {
            $this->timeSlotRepository->update(['start_time' => $startTime[$key], 'end_time' => $endTime[$key]], $id);
        }
        return redirect(route('time-slots.index'));
    }

    /**
     * Update the specified Schedule in storage.
     */
    public function update($id, UpdateScheduleRequest $request)
    {
        $schedule = $this->timeSlotRepository->find($id);

        if (empty($schedule)) {
            Flash::error('Schedule not found');

            return redirect(route('schedules.index'));
        }
        $input = $request->validated();
        $schedule = $this->timeSlotRepository->update($input, $id);
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
        $schedule = $this->timeSlotRepository->find($id);

        if (empty($schedule)) {
            Flash::error('Schedule not found');

            return redirect(route('schedules.index'));
        }

        $this->timeSlotRepository->delete($id);
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE_ALL',
            'eventName' => 'k12_schedule',
            'data' => null
        ]));
        Flash::success('Schedule deleted successfully.');

        return redirect(route('schedules.index'));
    }
}
