<?php

namespace Modules\AdaptiveLearning\Http\Controllers;

use App\Filters\TargetLanguageFilters;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateTargetLanguageRequest;
use App\Http\Requests\UpdateTargetLanguageRequest;
use Modules\AdaptiveLearning\Entities\TargetLanguage;
use App\Repositories\TargetLanguageRepository;
use Flash;
use Illuminate\Http\Request;
use Response;

class TargetLanguageController extends AppBaseController
{
    /** @var TargetLanguageRepository $targetLanguageRepository*/
    private $targetLanguageRepository;

    public function __construct(TargetLanguageRepository $targetLanguageRepo)
    {
        $this->targetLanguageRepository = $targetLanguageRepo;
    }

    /**
     * Display a listing of the TargetLanguage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(TargetLanguageFilters $filters)
    {
        $targetLanguages = $this->targetLanguageRepository->listByFiltersPaginate($filters);

        return view('adaptivelearning::pages.target_languages.index')
            ->with('targetLanguages', $targetLanguages);
    }

    /**
     * Show the form for creating a new TargetLanguage.
     *
     * @return Response
     */
    public function create()
    {
        return view('adaptivelearning::pages.target_languages.create');
    }

    /**
     * Store a newly created TargetLanguage in storage.
     *
     * @param CreateTargetLanguageRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $input = $request->all();

            $targetLanguage = $this->targetLanguageRepository->create($input);

            Flash::success(__('messages.saved', ['model' => __('models/targetLanguages.singular')]));

            return redirect(route('targetLanguages.index'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Display the specified TargetLanguage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $targetLanguage = $this->targetLanguageRepository->find($id);

        if (empty($targetLanguage)) {
            Flash::error(__('messages.not_found', ['model' => __('models/targetLanguages.singular')]));

            return redirect(route('targetLanguages.index'));
        }

        return view('adaptivelearning::pages.target_languages.show')->with('targetLanguage', $targetLanguage);
    }

    /**
     * Show the form for editing the specified TargetLanguage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $targetLanguage = $this->targetLanguageRepository->find($id);

        if (empty($targetLanguage)) {
            Flash::error(__('messages.not_found', ['model' => __('models/targetLanguages.singular')]));

            return redirect(route('targetLanguages.index'));
        }

        return view('adaptivelearning::pages.target_languages.edit')->with('targetLanguage', $targetLanguage);
    }

    /**
     * Update the specified TargetLanguage in storage.
     *
     * @param int $id
     * @param UpdateTargetLanguageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTargetLanguageRequest $request)
    {
        $targetLanguage = $this->targetLanguageRepository->find($id);

        if (empty($targetLanguage)) {
            Flash::error(__('messages.not_found', ['model' => __('models/targetLanguages.singular')]));

            return redirect(route('targetLanguages.index'));
        }

        $targetLanguage = $this->targetLanguageRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/targetLanguages.singular')]));

        return redirect(route('targetLanguages.index'));
    }

    /**
     * Remove the specified TargetLanguage from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $targetLanguage = $this->targetLanguageRepository->find($id);

        if (empty($targetLanguage)) {
            Flash::error(__('messages.not_found', ['model' => __('models/targetLanguages.singular')]));

            return redirect(route('targetLanguages.index'));
        }

        $this->targetLanguageRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/targetLanguages.singular')]));

        return redirect(route('targetLanguages.index'));
    }

    public function getTargetLanguage(Request $request)
    {

        $term = $request->get('search', null);
        $perPage = \Arr::get($request->get('search',[]), 'per_page',  15);

        $questions = $this->targetLanguageRepository
            ->where("target_language" , 'like' ,"%$term%")
            ->paginate($perPage,['*','target_language as name']);

        $questions->each(function(TargetLanguage $item) {
            $item->name = $item->getLabel();
        });

        return $this->responseSuccess($questions);
    }
}
