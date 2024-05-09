<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Repositories\GradeRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Redis;

class SubjectController extends AppBaseController
{
    /** @var SubjectRepository $subjectRepository*/
    private $subjectRepository;

    private $gradeRepository;

    public function __construct(SubjectRepository $subjectRepo, GradeRepository $gradeRepo)
    {
        $this->subjectRepository = $subjectRepo;
        $this->gradeRepository = $gradeRepo;
    }

    /**
     * Display a listing of the Subject.
     */
    public function index(Request $request)
    {
        $subjects = $this->subjectRepository->paginate(10);

        return view('subjects.index')
            ->with('subjects', $subjects);
    }

    /**
     * Show the form for creating a new Subject.
     */
    public function create()
    {
        $grades = $this->gradeRepository->baseQuery()->get()->pluck('title', 'id');

        return view('subjects.create')->with('grades', $grades);
    }

    /**
     * Store a newly created Subject in storage.
     */
    public function store(CreateSubjectRequest $request)
    {
        $input = $request->all();
        $subject = $this->subjectRepository->create($input);
        Flash::success('Subject saved successfully.');
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'INSERT',
            'eventName' => 'k12_subject',
            'data' => $subject->id
        ]));
        return redirect(route('subjects.index'));
    }

    /**
     * Display the specified Subject.
     */
//    public function show($id)
//    {
//        $subject = $this->subjectRepository->find($id);
//
//        if (empty($subject)) {
//            Flash::error('Subject not found');
//
//            return redirect(route('subjects.index'));
//        }
//
//        return view('subjects.show')->with('subject', $subject);
//    }

    /**
     * Show the form for editing the specified Subject.
     */
    public function edit($id)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        $grades = $this->gradeRepository->baseQuery()->get()->pluck('title', 'id');

        return view('subjects.edit')->with('subject', $subject)->with('grades', $grades);
    }

    /**
     * Update the specified Subject in storage.
     */
    public function update($id, UpdateSubjectRequest $request)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        $subject = $this->subjectRepository->update($request->all(), $id);
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE',
            'eventName' => 'k12_subject',
            'data' => $subject->id
        ]));
        Flash::success('Subject updated successfully.');

        return redirect(route('subjects.index'));
    }

    /**
     * Remove the specified Subject from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        $this->subjectRepository->delete($id);
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE_ALL',
            'eventName' => 'k12_subject',
            'data' => null
        ]));
        Flash::success('Subject deleted successfully.');

        return redirect(route('subjects.index'));
    }
}
