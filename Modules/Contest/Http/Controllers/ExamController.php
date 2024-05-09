<?php

namespace Modules\Contest\Http\Controllers;

use App\Repositories\SubjectRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Contest\Entities\Exam;
use Modules\Contest\Repositories\ExamRepository;

class ExamController extends Controller
{
    protected ExamRepository $examRepository;
    protected SubjectRepository $subjectRepository;

    public function __construct(ExamRepository $examRepository, SubjectRepository $subjectRepository)
    {
        $this->examRepository = $examRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function index(Request $request): Factory|View|Application
    {
        $paramsFilter = $request->all();
        $query = Exam::query();
        if (!empty($paramsFilter['title'])) {
            $query->where('title', 'like', '%' . $paramsFilter['title'] . '%');
        }
        if (!empty($paramsFilter['subject_id'])) {
            $query->where('subject_id', $paramsFilter['subject_id']);
        }
        if (!empty($paramsFilter['start_time'])) {
            $query->where('subject_id', "<=", $paramsFilter['start_time']);
        }
        if (!empty($paramsFilter['end_time'])) {
            $query->where('subject_id', ">=", $paramsFilter['end_time']);
        }
        if (!empty($paramsFilter['status'])) {
            $query->where('is_active', $paramsFilter['status']);
        }
        $listExam = $query->orderBy('id', 'DESC')->paginate(20);
        $subjects = $this->subjectRepository->baseQuery()->orderBy('updated_at')->get();

        return view('contest::pages.exams.index', compact('listExam', 'subjects'));
    }

    public function create()
    {
        $subjects = $this->subjectRepository->baseQuery()->orderBy('updated_at')->get();
        return view('contest::pages.exams.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        try {
            $this->examRepository->create($request->toArray());
            $request->session()->flash('message', 'Tạo mới bài thi thành công!');
            return redirect(route('exams.index'));
        } catch (\Exception $ex) {
            Log::error($ex);
            $request->session()->flash('message-error', $ex->getMessage());
            return back()->withInput($request->input());
        }
    }

    public function show($id)
    {
        return view('contest::pages.exams.show');
    }

    public function edit($id)
    {
        $exam = $this->examRepository->find($id);
        $subjects = $this->subjectRepository->baseQuery()->orderBy('updated_at')->get();
        return view('contest::pages.exams.edit', compact('subjects', 'exam'));
    }

    public function update(Request $request, $id)
    {
        try {
            $this->examRepository->update($request->toArray(), $id);
            $request->session()->flash('message', 'Cập nhập bài thi thành công!');
            return redirect()->back()->with('message', 'Cập nhập bài thi thành công!');
        } catch (\Exception $e) {
            Log::error($e);
            $request->session()->flash('message-error', $e->getMessage());
            return back()->withInput($request->input());
        }

    }

    public function destroy($id)
    {
        $this->examRepository->delete($id);
        return redirect(route('exams.index'));
    }
}
