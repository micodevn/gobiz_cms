<?php

namespace Modules\Contest\Http\Controllers\API;


use Modules\Contest\Exceptions\ContestException;
use Modules\Contest\Http\Requests\GenerateExamsRequest;
use Modules\Contest\Http\Requests\GetRankingRequest;
use Modules\Contest\Models\ContestRound;
use Modules\Contest\Models\Exam;
use Modules\Contest\Services\ContestRender\ContestFactory;
use Modules\Contest\Services\Educa\EducaBaseService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Contest\Http\Controllers\Controller;
use Modules\Contest\Repositories\ExamRepository;


class ExamController extends Controller
{
    protected ExamRepository $examRepository;
    protected EducaBaseService $serviceCurl;

    public function __construct(ExamRepository $examRepository, EducaBaseService $service)
    {
        $this->examRepository = $examRepository;
        $this->serviceCurl = $service;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $province_code  = $request->get('province_code', null);
        $district_code  = $request->get('district_code', null);
        $sort  = $request->get('sort', 'desc');
        $query = $this->contestRepo->newQuery();
        if ($province_code) {
            $query = $query->where("code", "like", "%$province_code%");
        }
        if ($district_code) {
            $query = $query->where("code", "like", "%$district_code%");
        }
        $rounds = $query->with('districts')->orderBy('id',$sort)->paginate($request->get('per_page', 10), [
            'id',
            'name',
            'code'
        ]);
        return $this->responseSuccess($rounds);
    }

    public function getExerciseList(Request $request)
    {
        $page = $request->get('page',1);
        $per_page = $request->get('per_page',15);
        $search = $request->get('search',null);
        $url = '/api/exercise-options?page='.$page .'&per_page='. $per_page. '&keywords='.$search;

        $types = $request->get('types', null);
        if ($types) {
            $url .= '&types=' . $types;
        }

        $res = $this->serviceCurl->requestInit($url);

        return $this->responseSuccess($res);
    }


    public function generateExam(GenerateExamsRequest $request)
    {
        $exam_id = $request->get('exam_id',null);
        $exam = $this->examRepository->generateExam($exam_id);

        return $this->responseSuccess($exam);
    }

    public function detailExam(GenerateExamsRequest $request)
    {
        $exam_id = $request->get('exam_id',null);

        $response = $this->examRepository->detailExam($exam_id);
        return $this->responseSuccess($response);

    }

    public function updateExerciseLogs(Request $request)
    {
        $response = [];
        return $this->responseSuccess($response);
    }

    public function getRankByContest(GetRankingRequest $request)
    {
        $contestRoundId = $request->get('contest_round_id',null);
        $user_id = $request->get('user_id',null);

        $contestRound = ContestRound::find($contestRoundId);

        if (empty($contestRound->examsOfficial)) throw new ContestException("Round missing Exam !");

        $contestProvider = (new ContestFactory($contestRound->contest))->createContestProvider();

        $response = $contestProvider->calculateRank($contestRound,$user_id);
        return $this->responseSuccess($response);
    }

}
