<?php

namespace Modules\Contest\Http\Controllers;

use App\Repositories\GradeRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Contest\Entities\Contest;
use Modules\Contest\Repositories\ContestRepository;

class ContestController extends Controller
{
    protected GradeRepository $gradeRepository;
    protected ContestRepository $contestRepo;

    public function __construct(GradeRepository $gradeRepository, ContestRepository $contestRepo,)
    {
        $this->gradeRepository = $gradeRepository;
        $this->contestRepo = $contestRepo;
    }

    public function index(Request $request): Factory|View|Application
    {
        $grades = $this->gradeRepository->all();
        $listContest = Contest::query()
            ->where(function ($query) use ($request) {
                if (!empty($request->title)) {
                    $query->where('title', 'like', '%' . $request->name . '%');
                }
                if (!empty($request->type)) {
                    $query->where('type', $request->type);
                }
            })
            ->orderBy('id', 'DESC')->paginate(20);
        return view('contest::pages.contests.index', compact('listContest', 'grades'));
    }

    public function create()
    {
        $grades = $this->gradeRepository->all();
        return view('contest::pages.contests.create', compact('grades'));
    }

    public function store(Request $request)
    {
        try {
            $params = $request->toArray();
            // TODO remove null item select2
            if (isset($params['thumbnail'])) {
                $params['thumbnail'] = array_values(array_filter($params['thumbnail']));
            }
            $this->contestRepo->create($params);
            return redirect(route('contests.index'));
        } catch (\Exception $ex) {
            Log::error($ex);
            $request->session()->flash('message-error', $ex->getMessage());
            return back()->withInput($request->input());
        }
    }

    public function show($id)
    {
        return view('contest::pages.contests.index');
    }

    public function edit($id)
    {
        try {
            $contest = $this->contestRepo->find($id);
            $grades = $this->gradeRepository->all();
            return view('contest::pages.contests.edit', compact('contest', 'grades'));
        } catch (\Exception $ex) {
            dd($ex);
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $params = $request->toArray();
            // TODO remove null item select2
            if (isset($params['thumbnail'])) {
                $params['thumbnail'] = array_values(array_filter($params['thumbnail']));
            }
            $this->contestRepo->update($params, $id);
            return redirect()->back()->with('message', 'Updated successfully!');
        } catch (\Exception $ex) {
            Log::error($ex);
            $request->session()->flash('message-error', $ex->getMessage());
            return back()->withInput($request->input());
        }
    }

    public function destroy($id)
    {
        //
    }
}
