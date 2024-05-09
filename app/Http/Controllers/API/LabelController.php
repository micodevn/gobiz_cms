<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFileRequest;
use App\Http\Resources\API\FileResource;
use App\Http\Resources\API\FileResourceCollection;
use App\Models\File;
use App\Repositories\FileRepository;
use App\Repositories\LabelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LabelController extends Controller
{
    protected LabelRepository $repository;

    public function __construct(LabelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request) {
        $keywords = $request->get('keywords', null);
        $id  = $request->get('id', null);
        $sort  = $request->get('sort', 'desc');

        $files = $this->repository->scopeQuery(function($query) use ($keywords,$id,$sort) {

            $keywords && $query = $query->where("name", "like", "%$keywords%");
            $id && $query = $query->where("id", $id);

            return $query;
        })->orderBy('id',$sort)->paginate($request->get('per_page', config('repository.pagination.limit')), [
            'id',
            'name',
        ]);

        return $this->responseSuccess($files);
    }

}
