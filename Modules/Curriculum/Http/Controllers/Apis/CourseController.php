<?php

namespace Modules\Curriculum\Http\Controllers\Apis;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Modules\Curriculum\Repositories\Level\UnitRepository;

class CourseController extends AppBaseController
{

    private UnitRepository $courseRepository;

    public function __construct(UnitRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->get('per_page', 15);
            $filters = ['title' => $request->get('search')];
            $lessons = $this->courseRepository->search($filters)->paginate($limit);

            return $this->responseSuccess($lessons);
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }
}
