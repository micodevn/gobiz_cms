<?php

namespace Modules\Curriculum\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Flash;
use Illuminate\Http\Request;
use Modules\Curriculum\Http\Requests\CreatePartRequest;
use Modules\Curriculum\Http\Requests\UpdatePartRequest;
use Modules\Curriculum\Repositories\Part\PartRepository;
use Modules\Curriculum\Repositories\Unit\WodRepository;
use Modules\Curriculum\Services\Part\PartService;

class PartController extends AppBaseController
{
    /** @var PartRepository $partRepository*/
    private $partRepository;

    private $unitRepository;
    private PartService $partService;

    public function __construct(PartService $partService, PartRepository $partRepo, WodRepository $unitRepository)
    {
        $this->partRepository = $partRepo;
        $this->unitRepository = $unitRepository;
        $this->partService = $partService;
    }

    /**
     * Display a listing of the Part.
     */
    public function index(Request $request)
    {
        $parts = $this->partRepository->search(['name' => ['like', $request->name]])->orderBy('updated_at')->paginate(10);
        $units = $this->unitRepository->baseQuery()->orderBy('updated_at')->get()->pluck('name', 'id');

        return view('curriculum::pages.parts.index')
            ->with(['parts' => $parts, 'units' => $units]);
    }

    /**
     * Show the form for creating a new Part.
     */
    public function create()
    {
        $units = $this->unitRepository->baseQuery()->get()->pluck('name', 'id');
//        dd($units);

        return view('curriculum::pages.parts.create')->with('units', $units);
    }

    /**
     * Store a newly created Part in storage.
     */
    public function store(CreatePartRequest $request)
    {
        $data = $request->validated();
        $part = $this->partService->store($data);
        Flash::success('Part saved successfully !');
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

        $units = $this->unitRepository->baseQuery()->get()->pluck('name', 'id');


        return view('curriculum::pages.parts.edit')->with(['part' => $part, 'units' => $units]);
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
