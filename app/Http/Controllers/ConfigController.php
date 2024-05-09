<?php

namespace App\Http\Controllers;

use App\Repositories\ConfigRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ConfigController extends Controller
{
    protected ConfigRepository $configRepository;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $listConfig = $this->configRepository->paginate(50);
            return view('configs.index', compact('listConfig'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $config = $this->configRepository->create($input);
        Flash::success('Config created successfully.');
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE_ALL',
            'eventName' => 'k12_config',
            'data' => $config->id
        ]));
        return redirect(route('configs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        try {
            $configDetail = $this->configRepository->find($id);
            if (empty($configDetail)) {
                Flash::error('Config not found');
                return redirect(route('configs.index'));
            }
            return view('configs.edit', compact('configDetail'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $findConfig = $this->configRepository->find($id);

            if (empty($findConfig)) {
                Flash::error('Config not found');
                return redirect(route('configs.index'));
            }

            $result = $this->configRepository->update($request->all(), $id);
            Flash::success('Config updated successfully.');
            Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
                'action' => 'UPDATE_ALL',
                'eventName' => 'k12_config',
                'data' => $result->id
            ]));
            return redirect()->back();
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
