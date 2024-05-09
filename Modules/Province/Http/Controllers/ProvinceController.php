<?php

namespace Modules\Province\Http\Controllers;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Province\Entities\Districts;
use Modules\Province\Repositories\ProvinceRepository;

class ProvinceController extends Controller
{
    protected ProvinceRepository $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    public function index(Request $request): Renderable
    {
        $data = $this->provinceRepository
            ->where(function ($query) use ($request) {
                if (!empty($request->name)) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                }
                if (!empty($request->code)) {
                    $query->where('code', $request->code);
                }
                if (!empty($request->type)) {
                    $query->where('type', $request->type);
                }
            })
            ->orderBy('id', 'DESC')->paginate(20);
        return view('province::pages.provinces.index', compact('data'));
    }

    public function create()
    {
        return view('province::pages.provinces.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        DB::beginTransaction();
        try {
            $attributes = $this->getAttributes($request);

            $unit = $this->provinceRepository->create($attributes);
            if ($unit) {
                DB::commit();
                return redirect()->route('provinces.index');
            } else {
                DB::rollback();
                return back()->withInput($request->input());
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            Log::error($e);
            return back()->withInput($request->input());
        }
    }


    public function show($id)
    {
        return true;
    }

    public function edit($id)
    {
        $province = $this->provinceRepository->find($id);
        return view('province::pages.provinces.edit', compact('province'));
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $province = $this->provinceRepository->find($id);

            if ($request->name != $province->name && $this->provinceRepository->where('name', $request->name)->first() != null) {
                return back()->withInput($request->input());
            }

            $attributes = $this->getAttributes($request);

            $update = $this->provinceRepository->update($attributes, $id);

            if ($update) {
                DB::commit();
                return redirect()->route('provinces.index');
            } else {
                DB::rollback();
                return back()->withInput($request->input());
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return back()->withInput($request->input());
        }
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

    /**
     * @param Request $request
     * @return array
     */
    protected function getAttributes(Request $request): array
    {
        $attributes = $request->only(['name', 'type', 'code']);

        $attributes['slug'] = \App\Helpers\Helper::changeToSlug($attributes['name'], true);

        return $attributes;
    }


}
