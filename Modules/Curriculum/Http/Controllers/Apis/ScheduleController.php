<?php

namespace Modules\Curriculum\Http\Controllers\Apis;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\API\QuestionPlatformResource;
use Illuminate\Http\Request;
use Modules\Curriculum\Repositories\Schedule\ScheduleRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ScheduleController extends AppBaseController
{
    private ScheduleRepository $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->get('per_page', 15);
            $filters = ['title' => $request->title];
            $schedules = $this->scheduleRepository->search($filters)->with(['timeSlots'])->paginate($limit);
            return $this->responseSuccess($schedules);
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $schedules = $this->scheduleRepository->with(['timeSlots'])->find($id);;
            return $this->responseSuccess($schedules);
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }
}
