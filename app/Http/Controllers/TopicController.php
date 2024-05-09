<?php

namespace App\Http\Controllers;

use App\Repositories\TopicRepository;
use Flash;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /** @var topicRepository $topicRepository*/
    private $topicRepository;

    public function __construct(TopicRepository $topicRepo)
    {
        $this->topicRepository = $topicRepo;
    }

    /**
     * Display a listing of the topic.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $topics = $this->topicRepository->paginate(20);

        return view('topics.index')
            ->with('topics', $topics);
    }

    /**
     * Show the form for creating a new topic.
     *
     * @return Response
     */
    public function create()
    {
        return view('topics.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $topic = $this->topicRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/topics.singular')]));

        return redirect(route('topics.index'));
    }

    /**
     * Display the specified topic.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $topic = $this->topicRepository->find($id);

        if (empty($topic)) {
            Flash::error(__('messages.not_found', ['model' => __('models/topics.singular')]));

            return redirect(route('topics.index'));
        }

        return view('topics.show')->with('topic', $topic);
    }

    /**
     * Show the form for editing the specified topic.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $topic = $this->topicRepository->find($id);

        if (empty($topic)) {
            Flash::error(__('messages.not_found', ['model' => __('models/topics.singular')]));

            return redirect(route('topics.index'));
        }

        return view('topics.edit')->with('topic', $topic);
    }

    public function update($id, Request $request)
    {
        $topic = $this->topicRepository->find($id);

        if (empty($topic)) {
            Flash::error(__('messages.not_found', ['model' => __('models/topics.singular')]));

            return redirect(route('topics.index'));
        }

        $topic = $this->topicRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/topics.singular')]));

        return redirect(route('topics.index'));
    }

    /**
     * Remove the specified topic from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $topic = $this->topicRepository->find($id);

        if (empty($topic)) {
            Flash::error(__('messages.not_found', ['model' => __('models/topics.singular')]));

            return redirect(route('topics.index'));
        }

        $this->topicRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/topics.singular')]));

        return redirect(route('topics.index'));
    }
}
