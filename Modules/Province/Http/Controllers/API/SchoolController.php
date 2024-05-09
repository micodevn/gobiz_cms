<?php

namespace Modules\Province\Http\Controllers\API;


use Illuminate\Http\Request;
use Modules\Province\Repositories\SchoolRepository;


class SchoolController
{
    protected SchoolRepository $schoolRepo;

    public function __construct(SchoolRepository $schoolRepo)
    {
        $this->schoolRepo = $schoolRepo;
    }
    public function responseSuccess($data = [], $message = "", $code = 0)
    {
        return response_success($data, $message, $code);
    }

    public function responseError($message = "", $code = 1000, $data = [])
    {
        return response_error($message, $code, $data);
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $schools = $this->schoolRepo->getList($request);
        return $this->responseSuccess($schools);
    }


}
