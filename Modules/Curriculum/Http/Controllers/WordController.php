<?php

namespace Modules\Curriculum\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Http\Request;
use Modules\Curriculum\Http\Requests\UpdateWordRequest;
use Modules\Curriculum\Repositories\Level\LevelRepository;
use Modules\Curriculum\Repositories\Word\WordRepository;
use Modules\Curriculum\Services\Word\WordService;

class WordController extends AppBaseController
{
    private WordRepository $wordRepository;
    private LevelRepository $levelRepository;

    public function __construct(
        WordService     $wordService,
        WordRepository   $wordRepository,
        LevelRepository $levelRepository,
    )
    {
        $this->wordRepository = $wordRepository;
        $this->wordService = $wordService;
        $this->levelRepository = $levelRepository;
    }

    /**
     * Display a listing of the Course.
     */
    public function index(Request $request)
    {
        $words = $this->wordRepository->orderBy('updated_at','DESC')->paginate(10);

        return view('curriculum::pages.words.index')
            ->with(['words' => $words]);
    }

    /**
     * Show the form for creating a new Course.
     */
    public function create()
    {
//        $levels = $this->levelRepository->baseQuery()->get()->pluck('title', 'id');

        return view('curriculum::pages.words.create');
    }

    /**
     * Store a newly created Course in storage.
     */
    public function store(UpdateWordRequest $request)
    {
        try {
            $input = $request->all();

            $levelNew = $this->wordService->store($input);
            if ($levelNew) {
                Flash::success('Word saved successfully.');
                return redirect(route('words.index'));
            }
            Flash::error('Word saved failed.');
            return redirect(route('words.index'));
        }  catch (\Throwable $exception) {
            dd($exception->getMessage());
            return redirect()->back()->with('message-error', $exception->getMessage());
        }

    }

    /**
     * Display the specified Course.
     */
//    public function show($id)
//    {
//        $course = $this->courseRepository->find($id);
//
//        if (empty($course)) {
//            Flash::error('Course not found');
//
//            return redirect(route('courses.index'));
//        }
//
//        return view('curriculum::pages.levels.show')->with('course', $course);
//    }

    /**
     * Show the form for editing the specified Course.
     */
    public function edit($id)
    {
        $word = $this->wordRepository->find($id);
//        $levels = $this->levelRepository->baseQuery()->get()->pluck('title', 'id')->toArray();
//        dd($levels);
        if (empty($word)) {
            Flash::error('Word not found !');

            return redirect(route('words.index'));
        }
        return view('curriculum::pages.words.edit', compact('word'));
    }

    /**
     * Update the specified Course in storage.
     */
    public function update($id, UpdateWordRequest $request)
    {
        try {
            // Transform data
            $word = $this->wordService->update($id, $request->all());
            if ($word) {
                Flash::success('Word updated successfully.');
                return redirect(route('words.index'));
            }
            Flash::success('Word update Failed.');
            return redirect(route('words.index'));
        } catch (\Throwable $exception) {
            dd($exception);
            return redirect()->back()->with('message-error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified Course from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $level = $this->wordRepository->find($id);

        if (empty($level)) {
            Flash::error('Word not found');

            return redirect(route('words.index'));
        }

        $this->wordRepository->delete($id);
        Flash::success('Word deleted successfully.');

        return redirect(route('words.index'));
    }
}
