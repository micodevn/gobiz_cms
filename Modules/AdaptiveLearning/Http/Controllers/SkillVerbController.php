<?php

namespace Modules\AdaptiveLearning\Http\Controllers;



use App\Filters\SkillVerbFilters;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\StoreSkillVerbRequest;
use App\Http\Requests\UpdateSkillVerbRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Modules\AdaptiveLearning\Repositories\SkillVerbRepository;

class SkillVerbController extends AppBaseController
{

    /** @var SkillVerbRepository $skillVerbRepository*/
    private $skillVerbRepository;

    public function __construct(SkillVerbRepository $skillVerbRepo)
    {
        $this->skillVerbRepository = $skillVerbRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListSkillVerb(Request $request)
    {

        $search = $request->all();
        $page = \Arr::get($search, 'per_page', 1);
        $term = \Arr::get($search, 'search', null);
        Paginator::currentPageResolver(function() use($page) {
            return $page;
        });

        $skillVerb = $this->skillVerbRepository
            ->groupLearningObj($term);
        $result = [];
        if(!$skillVerb->isEmpty()) {
            $grouped = $skillVerb->groupBy('parent_id');
            $root = $grouped->get('')->keyBy('id')->toArray();

            $children = $grouped->filter(function($val, $key) {
                return $key != '';
            });

            $result = $children->map(function ($val, $key) use($root) {
                /** @var Collection $val */
                return [
                    'text' => \Arr::get($root[$key], 'name'),
                    'id' => \Arr::get($root[$key], 'id'),
                    'children' => $val->map(function($child) {
                        return [
                            'text' => $child->name,
                            'id' => $child->id
                        ];
                    })->toArray()
                ];
            })->toArray();
        }
        $result = array_values($result);
        return $this->responseSuccess($result);
    }

    /**
     * Display a listing of the SkillVerb.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(SkillVerbFilters $filters)
    {
        $skillVerbs = $this->skillVerbRepository->with('parent')->listByFiltersPaginate($filters);

        return view('adaptivelearning::pages.skill_verbs.index')
            ->with('skillVerbs', $skillVerbs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adaptivelearning::pages.skill_verbs.create');
    }

    /**
     * Store a newly created in storage.
     *
     * @param StoreSkillVerbRequest $request
     *
     * @return Response
     */
    public function store(StoreSkillVerbRequest $request)
    {
        $input = $request->all();

        $skillVerb = $this->skillVerbRepository->create($input);
        Flash::success(__('messages.saved', ['model' => __('models/skillVerbs.singular')]));

        return redirect(route('skillVerbs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\AdaptiveLearning\Entities\SkillVerb  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $skillVerb = $this->skillVerbRepository->find($id);

        if (empty($skillVerb)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skillVerbs.singular')]));

            return redirect(route('skill_verbs.index'));
        }

        return view('adaptivelearning::pages.skill_verbs.show')->with('skillVerb', $skillVerb);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\AdaptiveLearning\Entities\SkillVerb  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $skillVerb = $this->skillVerbRepository->with('parent')->find($id);

        if (empty($skillVerb)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skillVerbs.singular')]));

            return redirect(route('skill_verbs.index'));
        }

        return view('adaptivelearning::pages.skill_verbs.edit')->with('skillVerb', $skillVerb);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSkillVerbRequest  $request
     * @param  \Modules\AdaptiveLearning\Entities\SkillVerb  $skillVerb
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateSkillVerbRequest $request)
    {
        $skillVerbs = $this->skillVerbRepository->find($id);

        if (empty($skillVerbs)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skillVerbs.singular')]));

            return redirect(route('skillVerbs.index'));
        }

        $this->skillVerbRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/skillVerbs.singular')]));

        return redirect(route('skillVerbs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\AdaptiveLearning\Entities\SkillVerb  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $liveClass = $this->skillVerbRepository->find($id);

        if (empty($liveClass)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skillVerbs.singular')]));

            return redirect(route('liveClasses.index'));
        }

        $this->skillVerbRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/skillVerbs.singular')]));

        return redirect(route('skillVerbs.index'));
    }

    public function optionNoParent(Request $request)
    {
        $limit = $request->get('limit', 10);
        $search = $request->get('search', []);
        $page = \Arr::get($search, 'page', 1);
        Paginator::currentPageResolver(function() use($page) {
            return $page;
        });

        $skillVerbChild = $this->skillVerbRepository
            ->scopeQuery(function ($query) {
                return $query->whereNull('parent_id');
            })
            ->paginate($limit,['name','id','is_active','parent_id']);

        return $this->responseSuccess($skillVerbChild);
    }
}
