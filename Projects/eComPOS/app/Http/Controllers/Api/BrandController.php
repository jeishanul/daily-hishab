<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $request = request();

        $search = $request->search;
        $page = $request->page ?? 1;
        $perPage = $request->per_page  ?? 15;
        $skip = ($page * $perPage) - $perPage;

        $brands = BrandRepository::query()->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })->latest('id');

        $total = $brands->count();

        return $this->json("All Brands", [
            'total' => $total,
            'brands' => BrandResource::collection($brands->skip($skip)->take($perPage)->get()),
        ]);
    }

    public function show(Brand $brand)
    {
        return $this->json("Brand", [
            'brand' => BrandResource::make($brand),
        ]);
    }

    public function store(BrandRequest $request)
    {
        $brand = BrandRepository::storeByRequest($request);
        return $this->json("Brand created successfully", [
            'brand' => BrandResource::make($brand),
        ]);
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $brand = BrandRepository::updateByRequest($request, $brand);
        return $this->json("Brand updated successfully", [
            'brand' => BrandResource::make($brand),
        ]);
    }

    public function destroy(Brand $brand)
    {
        $media = $brand->media;
        if ($media && Storage::exists($media->src)) {
            Storage::delete($media->src);
        }

        $brand->delete();
        return $this->json("Brand deleted successfully");
    }

}
