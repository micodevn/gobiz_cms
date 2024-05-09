<?php

namespace Modules\Province\Http\Controllers;

use Exception;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Modules\Province\Entities\Province;
use Modules\Province\Http\Requests\StoreDistrictRequest;
use Modules\Province\Repositories\DistrictRepository;

class DistrictController
{
    protected $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    public function index(Request $request)
    {
        $provinces = Province::all();
        $data = $this->districtRepository
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
                if (!empty($request->province_code)) {
                    $query->where('province_code', $request->province_code);
                }
            })
            ->orderBy('id', 'DESC')->paginate(20);
        return view('province::pages.districts.index', compact('data','provinces'));
    }

    public function create()
    {
        $provinces = Province::all();
        return view('province::pages.districts.create', compact('provinces'));
    }

    public function store(StoreDistrictRequest $request)
    {
        DB::beginTransaction();
        try {
            $attributes = $this->getAttributes($request);

            $district = $this->districtRepository->create($attributes);
            if ($district) {
                DB::commit();
                return redirect()->route('districts.index');
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

    public function edit($id)
    {
        $district = $this->districtRepository->find($id);
        $provinces = Province::all();
        return view('province::pages.districts.edit', compact('provinces', 'district'));
    }

    public function update($id, Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $attributes = $this->getAttributes($request);
            $update = $this->districtRepository->update($attributes, $id);

            if ($update) {
                DB::commit();
//                $request->session()->flash(self::DEFAULT_KEY_MESSAGE, 'Thành công!');
                return redirect()->route('districts.index');
            } else {
                DB::rollback();
//                $request->session()->flash(self::DEFAULT_KEY_MESSAGE_ERROR, 'Không thành công !, vui lòng thử lại !');
                return back()->withInput($request->input());
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
//            $request->session()->flash(self::DEFAULT_KEY_MESSAGE_ERROR, $e->getMessage());
            return back()->withInput($request->input());
        }
    }

    public function destroy($id)
    {

    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getAttributes(Request $request): array
    {
        $attributes = $request->only(['name', 'type', 'code', 'province_code']);

        $attributes['slug'] = Helper::changeToSlug($attributes['name'], true);

        return $attributes;
    }
}
