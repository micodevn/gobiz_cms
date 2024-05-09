<?php

namespace Modules\AdaptiveLearning\Http\Controllers;


use App\Http\Controllers\AppBaseController;
use App\Http\Requests\StoreConditionalRequest;
use App\Http\Requests\UpdateConditionalRequest;
use Laracasts\Flash\Flash;
use Modules\AdaptiveLearning\Entities\Goal;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Modules\AdaptiveLearning\Repositories\GoalRepository;


class GoalController extends AppBaseController
{

    private GoalRepository $goalRepository;

    public function __construct(GoalRepository $goalRepository)
    {
        $this->goalRepository = $goalRepository;
    }

    public function index(Request $request)
    {
        $goals = $this->goalRepository->all();
        return view('adaptivelearning::pages.goals.index', compact('goals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adaptivelearning::pages.goals.create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListGoal(Request $request)
    {

        $limit = $request->get('per_page', config('repository.pagination.limit'));
        $search = $request->get('search', null);

        $data = $this->goalRepository->scopeQuery(function ($query) use ($search) {
            /** @var Builder $query */
            $query = $query->where('is_active', true);
            $search && $query = $query->where('name', 'like', "%$search%");

            return $query;
        })->paginate($limit, [
            'id', 'name'
        ]);

        return $this->responseSuccess($data);
    }

    public function store(StoreConditionalRequest $request)
    {
        try {
            $input = $request->all();

            $this->goalRepository->create($input);
            Flash::success('Goal saved successfully.');
            return redirect(route('goals.index'));
        } catch (\Exception $exception) {
            Flash::success('Goal save failed.');
            return redirect(route('goals.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Modules\AdaptiveLearning\Entities\Goal $goal
     * @return \Illuminate\Http\Response
     */
    public function show(Goal $goal)
    {
        //
    }

    public function edit($id)
    {
        $goal = $this->goalRepository->find($id);

        if (empty($goal)) {
            Flash::error('Goal not found');
            return redirect(route('skill_verbs.index'));
        }

        return view('adaptivelearning::pages.goals.edit')->with('goal', $goal);
    }

    public function update(UpdateConditionalRequest $request, $id)
    {
        $goal = $this->goalRepository->find($id);

        if (empty($goal)) {
            Flash::error('Goal not found');
            return redirect(route('goals.index'));
        }
        $this->goalRepository->update($request->all(), $id);
        Flash::success('Goal updated successfully.');
        return redirect(route('goals.index'));
    }


    public function destroy($id)
    {
        $goal = $this->goalRepository->find($id);
        if (empty($goal)) {
            Flash::error('Goal not found');
            return redirect(route('goals.index'));
        }
        $this->goalRepository->delete($id);
        Flash::success('Goal destroyed successfully.');
        return redirect(route('goals.index'));
    }
}
