<?php

namespace Modules\Province\Http\Controllers;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Modules\Province\Entities\Districts;
use Modules\Province\Entities\Province;
use Modules\Province\Repositories\SchoolRepository;

class SchoolController
{

    protected SchoolRepository $schoolRepo;

    public function __construct(SchoolRepository $schoolRepository)
    {
        $this->schoolRepo = $schoolRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {

        $provinces = Province::all();
        $data = $this->schoolRepo
            ->where(function ($query) use ($request) {
                if (!empty($request->name)) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                }
                if (!empty($request->district_code)) {
                    $query->where('district_code', $request->district_code);
                }
            })->orderBy('created_at', 'DESC')->paginate(20);
        return view('province::pages.schools.index', compact('data','provinces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('province::pages.schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $attributes = $request->only(['name', 'district_code']);

            $district = Districts::query()->where('code', $attributes['district_code'])->first();

            if (!$district) throw new \Exception("Không tìm thấy thông tin quân/huyện");

            $attributes['district_id'] = $district->id;

            $this->schoolRepo->create($attributes);

            return redirect()->route('schools.index');

        } catch (Exception $e) {
//            $request->session()->flash(self::DEFAULT_KEY_MESSAGE_ERROR, $e->getMessage());
            return back()->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {

        $school = $this->schoolRepo->find($id);
        return view('province::pages.schools.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $attributes = $request->only(['name', 'district_code']);

            $district = Districts::query()->where('code', $attributes['district_code'])->first();

            if (!$district) throw new \Exception("Không tìm thấy thông tin quân/huyện");

            $attributes['district_id'] = $district->id;

            $school = $this->schoolRepo->update($attributes, $id);

            if ($school) {
//                $request->session()->flash(self::DEFAULT_KEY_MESSAGE, 'Thành công!');
                return redirect()->route('schools.index');
            }

//            $request->session()->flash(self::DEFAULT_KEY_MESSAGE_ERROR, 'Cập nhật school thất bại, xin vui lòng thử lại sau!');

            return back()->withInput($request->input())->withErrors(['error' => 'Vui lòng thử lại sau!']);

        } catch (Exception $e) {
//            $request->session()->flash(self::DEFAULT_KEY_MESSAGE_ERROR, $e->getMessage());
            return back()->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $school = $this->schoolRepo->find($id);

        if (empty($school)) {
//            session()->flash(self::DEFAULT_KEY_MESSAGE_ERROR, 'Không tìm thấy school');
            return redirect()->route('school.index');
        }

        $this->schoolRepo->delete($id);

//        session()->flash(self::DEFAULT_KEY_MESSAGE, 'Thành công!');

        return redirect()->route('school.index');
    }
}
