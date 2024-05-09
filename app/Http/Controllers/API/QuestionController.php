<?php

namespace App\Http\Controllers\API;

use App\Exceptions\BaseException;
use App\Http\Controllers\AppBaseController as Controller;
use App\Http\Resources\API\QuestionResourceCollection;
use App\Models\Exercise;
use App\Models\ExerciseQuestions;
use App\Models\Question;
use App\Repositories\ExerciseRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionController extends Controller
{
    protected QuestionRepository $repository;

    protected ExerciseRepository $exerciseRepository;

    protected int $max_import_questions;

    public function __construct(QuestionRepository $repository, ExerciseRepository $exerciseRepository)
    {
        $this->repository = $repository;
        $this->exerciseRepository = $exerciseRepository;

        $this->max_import_questions = intval(env('MAX_IMPORT_QUESTIONS', 20));
    }

    public function index(Request $request)
    {
        $limit = $request->get('per_page', config('repository.pagination.limit'));
        $sort  = $request->get('sort', 'desc');
        $data = $this->repository
            ->with([
                'platform.parent',
                'exercises'
            ])
            ->scopeQuery(function ($query) use ($request) {
            /** @var Builder $query */
            $exerciseId = $request->get('exercise_id',null);
            $name = $request->get('name',null);
            $from  = $request->get('from', null);
            $class_id  = $request->get('class_id', null);
            $id  = $request->get('id', null);
            $to  = $request->get('to', null);
            $topic_id  = $request->get('topic_id', null);
            $level  = $request->get('level', null);
            $platformId  = $request->get('platform_id', null);
            $pinToExercise  = $request->get('is_used', null);

            if ($exerciseId) {
                $relationTable = 'cm_' . (new ExerciseQuestions())->getTable();
                $questionTable = 'cm_' . (new Question())->getTable();
                $query = $query->whereRaw("${questionTable}.id in (select question_id from ${relationTable} where exercise_id=${exerciseId})");
            }

            if ($pinToExercise == 1) {
                $query = $query->whereHas('exercises');
            }elseif ($pinToExercise == -1) {
                $query = $query->doesntHave('exercises');

            }

            if ($name) {

                $query = $query->whereRaw(" is_active = 1 and ( name like '%${name}%' or description like '%${name}%' )");
            }

            $from && $query = $query->whereDate("created_at", ">=", date($from));
            $to && $query = $query->whereDate("created_at", "<=", date($to));
            $topic_id && $query = $query->where("topic_id", $topic_id);
            $level && $query = $query->where("level", $level);
            $id && $query = $query->where("id", $id);
            $class_id && $query = $query->where("class_id", $class_id);
            $platformId && $query = $query->where("platform_id", $platformId);

            return $query;
        })->orderBy('id',$sort)->paginate($limit);

        return $this->responseSuccess(new QuestionResourceCollection($data));
    }

    public function show($id)
    {
        /** @var Question $question */
        $question = $this->repository
            ->with([
                'platform',
                'platform.parent',
                'videoTimestamps'
            ])
            ->findWithCache($id);

        if (!$question) {
            throw new NotFoundHttpException(__('Question not found'));
        }

        return $this->responseSuccess([
            'question' => json_decode($question->getCacheData())
        ]);
    }

    private function storeSingle($attribute)
    {
        $questionArr = $this->repository->fill($attribute);
        $question = $this->repository->create($questionArr);

        return $question;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws BaseException
     * @throws \Throwable
     */
    public function storeMultiple(Request $request)
    {
        $questions = $request->get('questions', []);
        if (empty($questions)) {
            throw new BaseException('questions field is required, and must be array');
        }

        if (count($questions) > $this->max_import_questions) {
            throw new BaseException('Number of questions must be less than or equal to ' . $this->max_import_questions);
        }

        try {
            $results = [];
            DB::beginTransaction();
            foreach ($questions as $question) {
                $results[] = $this->storeSingle($question);
            }
            DB::commit();

            return $this->responseSuccess($results);
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
