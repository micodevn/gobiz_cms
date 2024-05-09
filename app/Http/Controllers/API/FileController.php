<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFileRequest;
use App\Http\Resources\API\FileResource;
use App\Http\Resources\API\FileResourceCollection;
use App\Models\File;
use App\Models\Label;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    protected FileRepository $repository;

    public function __construct(FileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->get('filters', []);
            $keywords = $request->get('search', null);
            $id = $request->get('id', null);
            $from = $request->get('from', null);
            $to = $request->get('to', null);
            $sort = $request->get('sort', 'desc');

            $files = $this->repository->scopeQuery(function ($query) use ($filters, $keywords, $id, $from, $to, $sort) {
                if (\Arr::has($filters, 'type')) {
                    $type = strtoupper(\Arr::get($filters, 'type'));
                    if (in_array($type, File::TYPE_LIST)) {
                        $query = $query->where('type', $type);
                    }
                }

                if (\Arr::get($filters, 'label')) {
                    $label = Label::query()->where('slug', \Arr::get($filters, 'label'))->select('id')->first();
                    if ($label) {
                        $query = $query->whereHas('labels', function ($query) use ($label) {
                            $query->where('label_id', $label->id);
                        });
                    }
                }

                $keywords && $query = $query->where("name", "like", "%$keywords%");
                $id && $query = $query->where("id", $id);
                $from && $query = $query->whereDate("created_at", ">=", date($from));
                $to && $query = $query->whereDate("created_at", "<=", date($to));
                return $query;
            })->orderBy('id', $sort)->paginate($request->get('per_page', config('repository.pagination.limit')), [
                'id',
                'name',
                'description',
                'type',
                'file_path',
                'is_active',
                'icon_file_path',
                'created_at'
            ]);

            return $this->responseSuccess($files);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function createFile(CreateFileRequest $request)
    {
        $inputs = $request->all();

        $usePhysicalFile = !is_string($request->get('file_path'));

        Log::info($request->get('file_path'));

        $file = $this->repository->create($inputs, $usePhysicalFile);
        $data['file'] = $file;
        return $this->responseSuccess($data);
    }
}
