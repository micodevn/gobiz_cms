<?php

namespace Modules\Curriculum\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Http\Request;
use Modules\Curriculum\Http\Requests\CreatePartRequest;
use Modules\Curriculum\Http\Requests\UpdatePartRequest;
use Modules\Curriculum\Repositories\Lesson\LessonRepository;
use Modules\Curriculum\Repositories\Part\PartRepository;
use Modules\Curriculum\Services\Part\PartService;

class PartController extends AppBaseController
{
    /** @var PartRepository $partRepository*/
    private $partRepository;

    private $lessonRepository;
    private PartService $partService;

    public function __construct(PartService $partService, PartRepository $partRepo, LessonRepository $lessonRepo)
    {
        $this->partRepository = $partRepo;
        $this->lessonRepository = $lessonRepo;
        $this->partService = $partService;
    }

    /**
     * Display a listing of the Part.
     */
    public function index(Request $request)
    {
        $parts = $this->partRepository->search(['title' => ['like', $request->name]])->orderBy('updated_at')->paginate(10);
        $lessons = $this->lessonRepository->baseQuery()->orderBy('updated_at')->get()->pluck('title', 'id');

        return view('curriculum::pages.parts.index')
            ->with(['parts' => $parts, 'lessons' => $lessons]);
    }

    /**
     * Show the form for creating a new Part.
     */
    public function create()
    {
        $lessons = $this->lessonRepository->baseQuery()->get()->pluck('title', 'id');

        return view('curriculum::pages.parts.create')->with('lessons', $lessons);
    }

    /**
     * Store a newly created Part in storage.
     */
    public function store(CreatePartRequest $request)
    {
        $data = $request->validated();
        $part = $this->partService->store($data);
        Flash::success('Part saved successfully.');
        return redirect(route('parts.index'));
    }

    /**
     * Display the specified Part.
     */
//    public function show($id)
//    {
//        $part = $this->partRepository->find($id);
//
//        if (empty($part)) {
//            Flash::error('Part not found');
//
//            return redirect(route('curriculum::pages.parts.index'));
//        }
//
//        return view('curriculum::pages.parts.show')->with('part', $part);
//    }

    /**
     * Show the form for editing the specified Part.
     */
    public function edit($id)
    {
        $part = $this->partRepository->find($id);

        if (empty($part)) {
            Flash::error('Part not found');

            return redirect(route('parts.index'));
        }

        $lessons = $this->lessonRepository->baseQuery()->get()->pluck('title', 'id');

        return view('curriculum::pages.parts.edit')->with(['part' => $part, 'lessons' => $lessons]);
    }

    /**
     * Update the specified Part in storage.
     */
    public function update($id, UpdatePartRequest $request)
    {
        try {
            $part = $this->partRepository->find($id);
            if (empty($part)) {
                Flash::error('Part not found');

                return redirect(route('parts.index'));
            }
            $part = $this->partService->update($id, $request->all());

            Flash::success('Part updated successfully.');

            return redirect(route('parts.index'));
        }catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Remove the specified Part from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $part = $this->partRepository->find($id);

        if (empty($part)) {
            Flash::error('Part not found');

            return redirect(route('parts.index'));
        }

        $this->partRepository->delete($id);

        Flash::success('Part deleted successfully.');

        return redirect(route('parts.index'));
    }
}
