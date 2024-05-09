<?php

namespace App\Http\Controllers;

use App\Filters\ExerciseTypeFilters;
use App\Http\Requests\CreateExerciseTypeRequest;
use App\Http\Requests\UpdateExerciseTypeRequest;
use App\Repositories\ExerciseTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ExerciseTypeController extends AppBaseController
{
    /** @var ExerciseTypeRepository $exerciseTypeRepository*/
    private $exerciseTypeRepository;

    public function __construct(ExerciseTypeRepository $exerciseTypeRepo)
    {
        $this->exerciseTypeRepository = $exerciseTypeRepo;
    }

    /**
     * Display a listing of the ExerciseType.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(ExerciseTypeFilters $filters)
    {
        $exerciseTypes = $this->exerciseTypeRepository->listByFiltersPaginate($filters);

        return view('exercise_types.index')
            ->with('exerciseTypes', $exerciseTypes);
    }

    /**
     * Show the form for creating a new ExerciseType.
     *
     * @return Response
     */
    public function create()
    {
        return view('exercise_types.create');
    }

    /**
     * Store a newly created ExerciseType in storage.
     *
     * @param CreateExerciseTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateExerciseTypeRequest $request)
    {
        $input = $request->all();

        $exerciseType = $this->exerciseTypeRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/exerciseTypes.singular')]));

        return redirect(route('exercise-types.index'));
    }

    /**
     * Display the specified ExerciseType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $exerciseType = $this->exerciseTypeRepository->find($id);

        if (empty($exerciseType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/exerciseTypes.singular')]));

            return redirect(route('exercise-types.index'));
        }

        return view('exercise_types.show')->with('exerciseType', $exerciseType);
    }

    /**
     * Show the form for editing the specified ExerciseType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $exerciseType = $this->exerciseTypeRepository->find($id);

        if (empty($exerciseType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/exerciseTypes.singular')]));

            return redirect(route('exercise-types.index'));
        }

        return view('exercise_types.edit')->with('exerciseType', $exerciseType);
    }

    /**
     * Update the specified ExerciseType in storage.
     *
     * @param int $id
     * @param UpdateExerciseTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExerciseTypeRequest $request)
    {
        $exerciseType = $this->exerciseTypeRepository->find($id);

        if (empty($exerciseType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/exerciseTypes.singular')]));

            return redirect(route('exercise-types.index'));
        }

        $exerciseType = $this->exerciseTypeRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/exerciseTypes.singular')]));

        return redirect(route('exercise-types.index'));
    }

    /**
     * Remove the specified ExerciseType from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $exerciseType = $this->exerciseTypeRepository->find($id);

        if (empty($exerciseType)) {
            Flash::error(__('messages.not_found', ['model' => __('models/exerciseTypes.singular')]));

            return redirect(route('exercise-types.index'));
        }

        $this->exerciseTypeRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/exerciseTypes.singular')]));

        return redirect(route('exercise-types.index'));
    }
}
