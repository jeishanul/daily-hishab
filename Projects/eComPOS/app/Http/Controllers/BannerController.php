<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('banner.index', compact('banners'));
    }

    public function store(BannerRequest $request)
    {
        BannerRepository::storeByRequest($request);
        return back()->with('success', 'Banner inserted successfully');
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        BannerRepository::updateByRequest($request, $banner);
        return back()->with('success', 'Banner updated successfully');
    }

    public function statusChange(Banner $banner)
    {
        $banner->update(['status' => !$banner->status]);
        return back()->with('success', 'Banner status changed successfully');
    }

    public function delete(Banner $banner)
    {
        $banner->delete();
        return back()->with('success', 'Banner deleted successfully');
    }
}
