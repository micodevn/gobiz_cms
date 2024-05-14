<?php

namespace App\Http\Controllers;

use App\Filters\FileFilters;
use App\Http\Requests\CreateFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\API\FileResource;
use App\Models\Exercise;
use App\Models\File;
use App\Models\Question;
use App\Repositories\FileRepository;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Routing\Redirector;
use Response;

class FileController extends AppBaseController
{
    /** @var FileRepository $fileRepository*/
    private $fileRepository;

    public function __construct(FileRepository $fileRepo)
    {
        $this->fileRepository = $fileRepo;
    }

    /**
     * Display a listing of the File.
     *
     * @param FileFilters $filters
     *
     * @return Response
     */
    public function index(FileFilters $filters)
    {
        $files = $this->fileRepository->listByFiltersPaginate($filters);

        return view('files.index')
            ->with('files', $files)
            ->with('types',File::TYPE_LIST);
    }

    /**
     * Show the form for creating a new File.
     *
     * @return Response
     */
    public function create()
    {
        return view('files.create');
    }


    public function store(CreateFileRequest $request): JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $input = $request->validated();
            $file = $this->fileRepository->create($input);

            if ($request->wantsJson()) {
                return $this->responseSuccess([
                    'file' => $file
                ]);
            }

            Flash::success(__('messages.saved', ['model' => __('models/files.singular')]));

            return redirect(route('files.index'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Display the specified File.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $file = $this->fileRepository->find($id);

        if (empty($file)) {
            Flash::error(__('messages.not_found', ['model' => __('models/files.singular')]));

            return redirect(route('files.index'));
        }

        return view('files.show')->with('file', $file);
    }

    /**
     * Show the form for editing the specified File.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $file = $this->fileRepository->find($id);

        if (empty($file)) {
            Flash::error(__('messages.not_found', ['model' => __('models/files.singular')]));

            return redirect(route('files.index'));
        }

        return view('files.edit')->with('file', $file);
    }

    public function update($id, UpdateFileRequest $request): Redirector|Application|RedirectResponse
    {
        try {
            $data = $request->validated();
            $file = $this->fileRepository->find($id);

            if (empty($file)) {
                Flash::error(__('messages.not_found', ['model' => __('models/files.singular')]));

                return redirect(route('files.index'));
            }

            $this->fileRepository->update($data, $id);
//            $this->syncWithQuestions($id);
            Flash::success(__('messages.updated', ['model' => __('models/files.singular')]));

            return redirect(route('files.index'));
        } catch (\Exception $exception) {
            dd($exception);
            return redirect(route('files.index'));
        }
    }

    /**
     * Remove the specified File from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $file = $this->fileRepository->find($id);

        if (empty($file)) {
            Flash::error(__('messages.not_found', ['model' => __('models/files.singular')]));

            return redirect(route('files.index'));
        }

        $this->fileRepository->deleteWithCache($id);

        Flash::success(__('messages.deleted', ['model' => __('models/files.singular')]));

        return redirect(route('files.index'));
    }

    public function optionList(Request $request)
    {
        $type = $request->get('filter_type', 'all');
        $limit = $request->get('limit', config('repository.pagination.limit'));
        $keyWords = $request->get('name', null);
        $filters = [];

        if ($type !== 'all') {
            $type = strtoupper($type);
            if ($type == File::TYPE_VIDEO || $type == File::TYPE_VIDEO_TIMESTAMP) {
                $type = [
                    'in',
                    [ File::TYPE_VIDEO, File::TYPE_VIDEO_TIMESTAMP ]
                ];
            }
            $filters['type'] = $type;
            $filters['is_active'] = true;
        }

        $query = $this->fileRepository
            ->search($filters,$keyWords)
            ->where('is_active',true)
            ->with([
                'videoTimestampsFileList',
                'videoSubtitles',
                'creator'
            ])->orderBy('id', 'desc');

        if ($request->get('without_id')) {
            $query = $query->where('id', '<>', $request->get('without_id'));
        }

        $data = $query->paginate($request->get('per_page', $limit), [
            'id', 'name', 'type', 'description', 'file_path', 'size', 'created_at', 'created_by'
        ]);

        return response_success($data);
    }

    public function replicateFile(Request $request)
    {
        $id = $request->get('id');
        $res = $this->fileRepository->relicate($id);
        if (!$res) return $this->responseError('err');
        return redirect(route('files.index'));
    }

    public function showSingle($id)
    {
        $file = $this->fileRepository->with('creator')->find($id);

        return $this->responseSuccess([
            'file' => FileResource::make($file)
        ]);
    }


    public function syncWithQuestions($id)
    {
        $value = '%id":"' . $id . '"%';

        /** @var Question $questions */
        $questions = Question::query()->where("question_content", "like", $value)
            ->orWhere("answers", "like", $value)->get();

        if ($questions) {
            $questions->load('exercises');
            foreach ($questions as $val) {
//                $val->cache();
                $exercises = $val->exercises;
                /** @var Exercise $exercise */
                foreach ($exercises as $exercise) {
//                    $exercise->cache();
                }
            }
        }
        return true;
    }

    public function detachAttribute($attribute, $question_id,$parentKey = ''): array
    {

        $result = Helper::flattenKeysRecursively($attribute,$parentKey);
        $questionAttrs = [];

        $index = 0;

        foreach ($result as $key => $value) {
            if(preg_match("/(image|audio|animation)/i", $key)){
                $type = 'RELATION';
                $type_option = 'App\Models\File';
            }else {
                $type = null;
                $type_option = null;
            }

            $parent = explode('.', $key);

            $key = str_replace($parent[0] . '.', '', $key);

            // for old data
            $key = str_replace('.value', '', $key);

            $questionAttr = [
                'question_id' => $question_id,
                'attribute' => $key,
                'group_parent' => $parent[0],
                'value' => $value,
                'type' => $type,
                'type_option' => $type_option
            ];

            $questionAttrs[] = $questionAttr;
            $index++;
        }

        return $questionAttrs;
    }
}
