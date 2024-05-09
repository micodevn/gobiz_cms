<?php

namespace Modules\Province\Http\Controllers\API;

use Illuminate\Http\Request;
use Modules\Province\Entities\Districts;
use Modules\Province\Repositories\ProvinceRepository;


class ProvinceController
{
    protected ProvinceRepository $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    public function responseSuccess($data = [], $message = "", $code = 0)
    {
        return response_success($data, $message, $code);
    }

    public function responseError($message = "", $code = 1000, $data = [])
    {
        return response_error($message, $code, $data);
    }

    public function index(Request $request)
    {
        $province_code = $request->get('province_code', null);
        $district_code = $request->get('district_code', null);
        $search = $request->get('search', null);
        $sort = $request->get('sort', 'desc');
        $query = $this->provinceRepository->query();
        if ($province_code) {
            $query = $query->where("code", "like", "%$province_code%");
        }

        if ($district_code) {
            $query = $query->where("code", "like", "%$district_code%");
        }
        if ($search) {
            $query = $query->where('name', 'like', "%$search%");
        }
        $rounds = $query->with('districts')->orderBy('id', $sort)->paginate($request->get('per_page', 10), [
            'id',
            'name',
            'code'
        ]);
        return $this->responseSuccess($rounds);
    }

    public function loadDistrict(Request $request)
    {
        $str = '';
        $districts = Districts::where('province_code', $request->province_code)->get();
        foreach ($districts as $district) {
            if ($request->district_code == $district->code) {
                $str .= '<option selected value="' . $district->code . '">' . $district->name . '</option>';
            } else {
                $str .= '<option value="' . $district->code . '">' . $district->name . '</option>';
            }
        }
        return response()->json(['data' => $str]);
    }
}
