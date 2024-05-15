<?php

namespace App\Http\Controllers;

use App\Filters\QuestionPlatFormFilters;
use App\Helpers\Helper;
use App\Http\Requests\CreateQuestionPlatformRequest;
use App\Http\Requests\UpdateQuestionPlatformRequest;
use App\Models\ExerciseAttribute;
use App\Repositories\QuestionPlatformRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Response;

class QuestionPlatformController extends AppBaseController
{
    /** @var QuestionPlatformRepository $questionPlatformRepository */
    private $questionPlatformRepository;

    public function __construct(QuestionPlatformRepository $questionPlatformRepo)
    {
        $this->questionPlatformRepository = $questionPlatformRepo;
    }

    public function index(Request $request)
    {
        try {
            $questionPlatforms = $this->questionPlatformRepository->orderBy('updated_at', 'DESC')->paginate(10);
            return view('question_platforms.index')
                ->with(['questionPlatforms' => $questionPlatforms]);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }


    public function create()
    {
        return view('question_platforms.create');
    }

    public function store(CreateQuestionPlatformRequest $request)
    {
        $input = $request->all();

        $questionPlatform = $this->questionPlatformRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/questionPlatforms.singular')]));

        return redirect(route('questionPlatforms.index'));
    }

    /**
     * Display the specified QuestionPlatform.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $questionPlatform = $this->questionPlatformRepository->find($id);

        if (empty($questionPlatform)) {
            Flash::error(__('messages.not_found', ['model' => __('models/questionPlatforms.singular')]));

            return redirect(route('questionPlatforms.index'));
        }

        return view('question_platforms.show')->with('questionPlatform', $questionPlatform);
    }

    public function edit($id)
    {
        $questionPlatform = $this->questionPlatformRepository->find($id);
        if (empty($questionPlatform)) {
            Flash::error(__('messages.not_found', ['model' => __('models/questionPlatforms.singular')]));

            return redirect(route('questionPlatforms.index'));
        }

        return view('question_platforms.edit')->with('questionPlatform', $questionPlatform);
    }

    public function update($id, UpdateQuestionPlatformRequest $request)
    {
        $questionPlatform = $this->questionPlatformRepository->find($id);

        if (empty($questionPlatform)) {
            Flash::error(__('messages.not_found', ['model' => __('models/questionPlatforms.singular')]));

            return redirect(route('questionPlatforms.index'));
        }

        $questionPlatform = $this->questionPlatformRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/questionPlatforms.singular')]));

        return redirect(route('questionPlatforms.index'));
    }
    public function destroy($id)
    {
        $questionPlatform = $this->questionPlatformRepository->find($id);

        if (empty($questionPlatform)) {
            Flash::error(__('messages.not_found', ['model' => __('models/questionPlatforms.singular')]));

            return redirect(route('questionPlatforms.index'));
        }

        $this->questionPlatformRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/questionPlatforms.singular')]));

        return redirect(route('questionPlatforms.index'));
    }

    public function optionList(Request $request)
    {
        $limit = $request->get('limit', 10);
        $search = $request->get('search', null);
        $page = $request->get('page', 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $questionPlatforms = $this->questionPlatformRepository
            ->scopeQuery(function ($query) use ($search) {
                $query = $query->whereNull('parent_id');
                if ($search) {
                    $query = $query->where('name', 'like', "%$search%");
                }
                return $query;
            })
            ->orderBy('id', 'desc')->paginate($limit);

        return $this->responseSuccess($questionPlatforms);
    }

    public function groupOptionList(Request $request)
    {
        $search = $request->get('search', []);
        $page = \Arr::get($search, 'page', 1);
        $term = \Arr::get($search, 'term', '');
        if (!is_array($search)) {
            $term = $search;
        }
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $questionPlatforms = $this->questionPlatformRepository
            ->getGroupedPlatform($term);

        $grouped = $questionPlatforms->groupBy('parent_id');

        $root = $grouped->get('')->keyBy('id')->toArray();

        $children = $grouped->filter(function ($val, $key) {
            return $key != '';
        });

        $result = $children->map(function ($val, $key) use ($root) {
            /** @var Collection $val */
            return [
                'text' => '[' . \Arr::get($root[$key], 'code') . '] ' . \Arr::get($root[$key], 'name'),
                'children' => $val->map(function ($child) {
                    return [
                        'text' => '[' . $child->code . '] ' . $child->name,
                        'id' => $child->id
                    ];
                })->toArray()
            ];
        })->toArray();

        $result = array_values($result);

        $result = \Arr::prepend($result, [
            'text' => 'Other Platform',
            'children' => [
                ExerciseAttribute::OTHER_PLATFORM
            ]
        ]);

        return $this->responseSuccess($result);
    }
}
