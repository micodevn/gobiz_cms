<?php

namespace Modules\Curriculum\Http\Controllers\Apis;

use App\Http\Controllers\AppBaseController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Curriculum\Repositories\Lesson\LessonRepository;

class LessonController extends AppBaseController
{

    private LessonRepository $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->get('per_page', 100);
            $filters = ['type' => $request->get('type', 1)];
            $keywords = $request->get('search',null);
            $query = $this->lessonRepository->newQuery();
            if ($keywords) {
                $query = $query->where("title", "like", "%$keywords%")->orWhere('id' , $keywords);
            }
            $lessons = $query->where($filters)->orderByDesc('updated_at')->paginate(100);

            return $this->responseSuccess($lessons);
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('curriculum::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('curriculum::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('curriculum::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
