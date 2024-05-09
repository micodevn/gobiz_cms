<?php

namespace Modules\AdaptiveLearning\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConditionalRequest;
use App\Http\Requests\UpdateConditionalRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Modules\AdaptiveLearning\Entities\Conditional;
use Modules\AdaptiveLearning\Repositories\ConditionalRepository;

class ConditionalController extends Controller
{
    /** @var ConditionalRepository $conditionalRepository */
    private $conditionalRepository;

    public function __construct(ConditionalRepository $conditionalRepository)
    {
        $this->conditionalRepository = $conditionalRepository;
    }

    public function index(Request $request)
    {
        $conditionals = $this->conditionalRepository->all();
        return view('adaptivelearning::pages.conditionals.index', compact('conditionals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adaptivelearning::pages.conditionals.create');
    }


    public function store(StoreConditionalRequest $request)
    {
        try {
            $input = $request->all();

            $this->conditionalRepository->create($input);
            Flash::success('Conditional saved successfully.');
            return redirect(route('conditionals.index'));
        } catch (\Exception $exception) {
            Flash::success('Conditional save failed.');
            return redirect(route('conditionals.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Modules\AdaptiveLearning\Entities\Conditional $conditional
     * @return \Illuminate\Http\Response
     */
    public function show(Conditional $conditional)
    {
        //
    }

    public function edit($id)
    {
        $conditional = $this->conditionalRepository->find($id);

        if (empty($conditional)) {
            Flash::error('Conditional not found');
            return redirect(route('skill_verbs.index'));
        }

        return view('adaptivelearning::pages.conditionals.edit')->with('conditional', $conditional);
    }

    public function update(UpdateConditionalRequest $request, $id)
    {
        $conditional = $this->conditionalRepository->find($id);

        if (empty($conditional)) {
            Flash::error('Conditional not found');
            return redirect(route('conditionals.index'));
        }
        $this->conditionalRepository->update($request->all(), $id);
        Flash::success('Conditional updated successfully.');
        return redirect(route('conditionals.index'));
    }


    public function destroy($id)
    {
        $conditional = $this->conditionalRepository->find($id);
        if (empty($conditional)) {
            Flash::error('Conditional not found');
            return redirect(route('conditionals.index'));
        }
        $this->conditionalRepository->delete($id);
        Flash::success('Conditional destroyed successfully.');
        return redirect(route('conditionals.index'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListConditional(Request $request)
    {

        $limit = $request->get('per_page', config('repository.pagination.limit'));
        $search = $request->get('search', null);

        $data = $this->conditionalRepository->scopeQuery(function ($query) use ($search) {
            /** @var Builder $query */
            $query = $query->where('is_active', true);
            $search && $query = $query->where('name', 'like', "%$search%");
            return $query;
        })->paginate($limit, [
            'id', 'name'
        ]);

        return $this->responseSuccess($data);
    }
}
