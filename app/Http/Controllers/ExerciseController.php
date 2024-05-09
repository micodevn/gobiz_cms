<?php

namespace App\Http\Controllers;

use App\Filters\ExerciseFilters;
use App\Http\Requests\CreateExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Models\Exercise;
use App\Repositories\ExerciseRepository;
use App\Repositories\ExerciseTypeRepository;
use App\Repositories\QuestionPlatformRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Response;

;

use App\Http\Services\CurlInitCustom;

class ExerciseController extends AppBaseController
{
    /** @var ExerciseRepository $exerciseRepository */
    private $exerciseRepository;

    /** @var QuestionRepository $questionRepository */
    private $platformRepository;

    protected ExerciseTypeRepository $exerciseTypeRepository;

    protected CurlInitCustom $curlInitCustom;

    public function __construct(ExerciseRepository $exerciseRepo, QuestionPlatformRepository $platformRepo, ExerciseTypeRepository $exerciseTypeRepo, CurlInitCustom $CurlCustom)
    {
        $this->exerciseRepository = $exerciseRepo;
        $this->platformRepository = $platformRepo;
        $this->exerciseTypeRepository = $exerciseTypeRepo;
        $this->curlInitCustom = $CurlCustom;
    }

    public function index(ExerciseFilters $filters)
    {
        try {
            $exercises = $this->exerciseRepository->listByFiltersPaginate($filters);
            $platform = $this->platformRepository->all([], null, null, ['id', 'name']);
            $listTopics = $this->curlInitCustom->getListTopicC1Math(config('app.edupia_math_domain') . '/topic/active', 'GET', [], true);
            return view('exercises.index')
                ->with('exercises', $exercises)->with('platforms', $platform)->with('listTopics', $listTopics);
        } catch (\Exception $ex) {
            dd($ex);
        }
    }

    /**
     * Show the form for creating a new Exercise.
     *
     * @return Response
     */
    public function create()
    {
        // lấy danh sách topic active bên toán c1
        $listTopics = $this->curlInitCustom->getListTopicC1Math(config('app.edupia_math_domain') . '/topic/active', 'GET', [], true);
        return view('exercises.create')->with('listTopics', $listTopics);
    }

    /**
     * Store a newly created Exercise in storage.
     *
     * @param CreateExerciseRequest $request
     *
     * @return Response
     */
    public function store(CreateExerciseRequest $request)
    {
        try {
            $input = $request->all();

            $exercise = $this->exerciseRepository->createWithCache($input);

            Flash::success(__('Tạo thành công Exercise!', ['model' => __('models/exercises.singular')]));

            return redirect(route('exercises.index'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Display the specified Exercise.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $exercise = $this->exerciseRepository->with('questions')->find($id);
        if (empty($exercise)) {
            Flash::error(__('messages.not_found', ['model' => __('models/exercises.singular')]));

            return redirect(route('exercises.index'));
        }

        return view('exercises.show')->with('exercise', $exercise);
    }


    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        // lấy danh sách topic active bên toán c1
        $listTopics = $this->curlInitCustom->getListTopicC1Math(config('app.edupia_math_domain') . '/topic/active', 'GET', [], true);
        $exercise = $this->exerciseRepository->with(['questions'])->find($id);
        if (empty($exercise)) {
            Flash::error(__('messages.not_found', ['model' => __('models/exercises.singular')]));

            return redirect(route('exercises.index'));
        }

        return view('exercises.edit')->with('exercise', $exercise)->with('listTopics', $listTopics);
    }

    /**
     * Update the specified Exercise in storage.
     *
     * @param int $id
     * @param UpdateExerciseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExerciseRequest $request)
    {
        try {
            $exercise = $this->exerciseRepository->find($id);
            if (empty($exercise)) {
                Flash::error(__('messages.not_found', ['model' => __('models/exercises.singular')]));

                return redirect(route('exercises.index'));
            }

            $exercise = $this->exerciseRepository->updateWithCache($request->all(), $id);

            Flash::success(__('messages.updated', ['model' => __('models/exercises.singular')]));

            return redirect(route('exercises.index'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Remove the specified Exercise from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $exercise = $this->exerciseRepository->find($id);

        if (empty($exercise)) {
            Flash::error(__('messages.not_found', ['model' => __('models/exercises.singular')]));

            return redirect(route('exercises.index'));
        }

        $this->exerciseRepository->deleteWithCache($id);

        Flash::success(__('messages.deleted', ['model' => __('models/exercises.singular')]));

        return redirect(route('exercises.index'));
    }


    public function replicateExercise(Request $request)
    {
        $id = $request->get('id');

        $model = $this->exerciseRepository->find($id);
        if (!$model) return false;
        $clone = $model->replicate();
        if (!$clone) return $this->responseError('err');

        foreach ($model->questions as $question) {
            $clone->questions()->attach($question);
        }

        $clone->push();
        return redirect(route('exercises.index'));
    }

    public function listExerciseType(Request $request)
    {
        $limit = $request->get('limit', 10);
        $search = $request->get('search', []);
        $page = \Arr::get($search, 'page', 1);

//        Paginator::currentPageResolver(function() use($page) {
//            return $page;
//        });
        $query = $this->exerciseTypeRepository;
        if ($search) {
            $query = $this->exerciseTypeRepository->where("name", "like", "%$search%");
        }
        $questionPlatforms = $query->paginate($limit);
        return $this->responseSuccess($questionPlatforms);
    }

    public function listExercises(Request $request)
    {
        $kw = $request->get('search');
        $limit = $request->get('per_page', config('repository.pagination.limit'));
        $query = $this->exerciseRepository->newQuery();

        if ($kw) {
            $query = $query->where("name", "like", "%$kw%")->orWhere('id' , $kw);
        }

        $exercises = $query->paginate($limit);
        return $this->responseSuccess($exercises);
    }
}
