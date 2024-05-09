<?php

namespace App\Http\Controllers;

use App\Repositories\BannerRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BannerController extends Controller
{
    protected BannerRepository $bannerRepository;

    public function __construct(bannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function index()
    {
        try {
            $listBanner = $this->bannerRepository->paginate(50);
            return view('banners.index', compact('listBanner'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('banners.create');
    }

    public function store(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $input = $request->all();
        $banner = $this->bannerRepository->create($input);
        Flash::success('Banner created successfully.');
        Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
            'action' => 'UPDATE_ALL',
            'eventName' => 'k12_banners',
            'data' => $banner->id
        ]));
        return redirect(route('banners.index'));
    }

    public function show($id): bool
    {
        return false;
    }


    public function edit($id)
    {
        try {
            $banner = $this->bannerRepository->find($id);
            if (empty($banner)) {
                Flash::error('Banner not found');
                return redirect(route('banners.index'));
            }
            return view('banners.edit', compact('banner'));
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $findConfig = $this->bannerRepository->find($id);

            if (empty($findConfig)) {
                Flash::error('Banner not found');
                return redirect(route('banners.index'));
            }

            $result = $this->bannerRepository->update($request->all(), $id);
            Flash::success('Banner updated successfully.');
            Redis::rpush('k12:product:cms:system:data:cache:queue', json_encode([
                'action' => 'UPDATE_ALL',
                'eventName' => 'k12_banners',
                'data' => $result->id
            ]));
            return redirect()->back();
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function destroy($id): bool
    {
        return false;
    }
}
