<?php

namespace App\Http\Controllers;

use App\Filters\QuestionFilters;
use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\QuestionPlatform;
use App\Repositories\QuestionPlatformRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\TopicRepository;
use Illuminate\Http\Request;
use Flash;
use Response;

class QuestionController extends AppBaseController
{
    /** @var QuestionRepository $questionRepository */
    private $questionRepository;

    /** @var QuestionPlatformRepository $platformRepository */
    private $platformRepository;


    public function __construct(QuestionRepository $questionRepo, QuestionPlatformRepository $platformRepo)
    {
        $this->questionRepository = $questionRepo;
        $this->platformRepository = $platformRepo;
    }

    /**
     * Display a listing of the Question.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(QuestionFilters $filters)
    {
        $questions = $this->questionRepository
            ->with([
                'thumbnailPath',
                'creator',
                'platform'
            ])
            ->listByFiltersPaginate($filters);
        $listTopics = [];

        return view('questions.index')
            ->with('questions', $questions)->with('listTopics', $listTopics);
    }

    /**
     * Show the form for creating a new Question.
     *
     * @return Response
     */
    public function create()
    {
        $listTopics = [];
        return view('questions.create')->with('listTopics', $listTopics);
    }

    /**
     * Store a newly created Question in storage.
     *
     * @param CreateQuestionRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            $question = $this->questionRepository->createWithCache($input);

            Flash::success(__('messages.saved', ['model' => __('models/questions.singular')]));

            return redirect(route('questions.index'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Display the specified Question.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            Flash::error(__('messages.not_found', ['model' => __('models/questions.singular')]));

            return redirect(route('questions.index'));
        }

        return view('questions.show')->with('question', $question);
    }

    /**
     * Show the form for editing the specified Question.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository
            ->find($id);
        if (empty($question)) {
            Flash::error(__('messages.not_found', ['model' => __('models/questions.singular')]));

            return redirect(route('questions.index'));
        }
        $listTopics = $this->topicRepository->all()->pluck('name', 'id');

        return view('questions.edit')->with('question', $question)->with('listTopics', $listTopics)->with('id_edit', $id);;
    }

    /**
     * Update the specified Question in storage.
     *
     * @param int $id
     * @param UpdateQuestionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuestionRequest $request)
    {
        try {
            $question = $this->questionRepository->find($id);

            if (empty($question)) {
                Flash::error(__('messages.not_found', ['model' => __('models/questions.singular')]));

                return redirect(route('questions.index'));
            }
            $this->questionRepository->updateWithCache($request->all(), $id);

            Flash::success(__('messages.updated', ['model' => __('models/questions.singular')]));

            return redirect(route('questions.index'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Remove the specified Question from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            Flash::error(__('messages.not_found', ['model' => __('models/questions.singular')]));

            return redirect(route('questions.index'));
        }
        $question->syntheticIdQuestionWithLevel(true);
        $this->questionRepository->deleteWithCache($id);

        Flash::success(__('messages.deleted', ['model' => __('models/questions.singular')]));

        return redirect(route('questions.index'));
    }

    public function getQuestionActive(Request $request)
    {
        $term = $request->get('search', null);
        $perPage = \Arr::get($request->get('search', []), 'per_page', 15);
        if (is_array($term)) {
            $term = !empty($term['term']) ? $term['term'] : null;
        }

        $request->merge([
            'name' => $term
        ]);

        $question = $this->questionRepository
            ->where("name", 'like', "%$term%")
            ->where("is_active", true)
            ->paginate($perPage);
        return $this->responseSuccess($question);
    }

    public function replicateQuestion(Request $request)
    {
        $id = $request->get('id');
        $res = $this->questionRepository->relicate($id);
        if (!$res) return $this->responseError('err');
        return redirect(route('questions.index'));
    }

    public function getResponseExampleDataAttr(Request $request)
    {
        $inputs = $request->all();
        $response = $this->questionRepository->getResponseExampleDataAttr($inputs);
        if (!$response) return $this->responseError('error');
        $data['response_example'] = $response;
        return $this->responseSuccess($data);
    }


    public function getQuestionTypeSync(Request $request)
    {
        $platformId = QuestionPlatform::query()->whereHas('parent', function ($q) {
                return $q->where('code', 13);
            })->get()->pluck('id') ?? [];

        $term = $request->get('search', null);
        $currentId = $request->get('currentId', null);
        $perPage = \Arr::get($request->get('search', []), 'per_page', 15);
        if (is_array($term)) {
            $term = !empty($term['term']) ? $term['term'] : null;
        }

        $request->merge([
            'name' => $term
        ]);

        $question = $this->questionRepository
            ->where("name", 'like', "%$term%")
            ->where("is_active", true)
            ->where("id", '!=', $currentId)
            ->whereIn("platform_id", $platformId)
            ->paginate($perPage);
        return $this->responseSuccess($question);
    }
}
