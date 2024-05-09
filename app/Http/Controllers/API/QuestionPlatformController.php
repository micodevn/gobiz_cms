<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\QuestionPlatformResource;
use App\Repositories\QuestionPlatformRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionPlatformController extends Controller
{
    protected QuestionPlatformRepository $repository;

    public function __construct(QuestionPlatformRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $filters = $request->get('filters', []);

        $platforms = $this->repository->all($filters);

        return $this->responseSuccess([
            'platforms' => $platforms
        ]);
    }

    public function show($id)
    {
        $platform = $this->repository->findWithCache($id);

        if (!$platform) {
            throw new NotFoundHttpException('Platform not found');
        }

        return $this->responseSuccess([
            'platform' => QuestionPlatformResource::make($platform)
        ]);
    }

    public function detail(Request $request)
    {
        $id = $request->get('id',null);
        $platform = $this->repository->with('parent')->find($id);

        if (!$platform) {
            throw new NotFoundHttpException('Platform not found');
        }

        return $this->responseSuccess([
            'platform' => QuestionPlatformResource::make($platform)
        ]);
    }
}
