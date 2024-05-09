<?php

namespace Modules\AdaptiveLearning\Http\Controllers;

use App\Filters\LearningObjectiveFilters;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateLearningObjectiveRequest;
use App\Http\Requests\UpdateLearningObjectiveRequest;
use Flash;
use Illuminate\Http\Request;
use Modules\AdaptiveLearning\Repositories\LearningObjectiveRepository;
use Response;

class LearningObjectiveController extends AppBaseController
{
    /** @var LearningObjectiveRepository $learningObjectiveRepository*/
    private $learningObjectiveRepository;

    public function __construct(LearningObjectiveRepository $learningObjectiveRepo)
    {
        $this->learningObjectiveRepository = $learningObjectiveRepo;
    }

    /**
     * Display a listing of the LearningObjective.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(LearningObjectiveFilters $filters)
    {
        $learningObjectives = $this->learningObjectiveRepository->with(['skillVerb','learningGoal','learningConditional'])->orderBy('id','desc')->listByFiltersPaginate($filters);

        return view('adaptivelearning::pages.learning_objectives.index')
            ->with('learningObjectives', $learningObjectives);
    }

    /**
     * Show the form for creating a new LearningObjective.
     *
     * @return Response
     */
    public function create()
    {
        return view('adaptivelearning::pages.learning_objectives.create');
    }

    /**
     * Store a newly created LearningObjective in storage.
     *
     * @param CreateLearningObjectiveRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateLearningObjectiveRequest $request)
    {
        $input = $request->all();

        $learningObjective = $this->learningObjectiveRepository->createWithCache($input);
        if ($request->wantsJson()) {
            return $this->responseSuccess([
                'learningObj' => $learningObjective
            ]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/learningObjectives.singular')]));

        return redirect(route('learningObjectives.index'));
    }

    /**
     * Display the specified LearningObjective.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $learningObjective = $this->learningObjectiveRepository->find($id);

        if (empty($learningObjective)) {
            Flash::error(__('messages.not_found', ['model' => __('models/learningObjectives.singular')]));

            return redirect(route('learningObjectives.index'));
        }

        return view('adaptivelearning::pages.learning_objectives.show')->with('learningObjective', $learningObjective);
    }

    /**
     * Show the form for editing the specified LearningObjective.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $learningObjective = $this->learningObjectiveRepository->with([
            'skillVerb','learningGoal','learningConditional'
        ])->find($id);

        if (empty($learningObjective)) {
            Flash::error(__('messages.not_found', ['model' => __('models/learningObjectives.singular')]));

            return redirect(route('learningObjectives.index'));
        }

        return view('adaptivelearning::pages.learning_objectives.edit')->with('learningObjective', $learningObjective);
    }

    /**
     * Update the specified LearningObjective in storage.
     *
     * @param int $id
     * @param UpdateLearningObjectiveRequest $request
     *
     * @return Response
     */
    public function update($id,Request $request)
    {
        $learningObjective = $this->learningObjectiveRepository->with(['skillVerb','learningGoal','learningConditional'])->find($id);

        if (empty($learningObjective)) {
            Flash::error(__('messages.not_found', ['model' => __('models/learningObjectives.singular')]));

            return redirect(route('learningObjectives.index'));
        }

        $learningObjective = $this->learningObjectiveRepository->updateWithCache($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/learningObjectives.singular')]));

        return redirect(route('learningObjectives.index'));
    }

    /**
     * Remove the specified LearningObjective from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $learningObjective = $this->learningObjectiveRepository->find($id);

        if (empty($learningObjective)) {
            Flash::error(__('messages.not_found', ['model' => __('models/learningObjectives.singular')]));

            return redirect(route('learningObjectives.index'));
        }

        $this->learningObjectiveRepository->deleteWithCache($id);

        Flash::success(__('messages.deleted', ['model' => __('models/learningObjectives.singular')]));

        return redirect(route('learningObjectives.index'));
    }

    public function listLearningOption(Request $request)
    {

        $term = $request->get('search', null);
        $perPage = $request->get('per_page', 15);


        $request->merge([
            'name' => $term
        ]);

        $question = $this->learningObjectiveRepository
            ->where("code" , 'like' ,"%$term%")
            ->paginate($perPage,['*','code as name']);
        return $this->responseSuccess($question);

    }
}
