<?php

namespace App\Repositories;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;

class BrandRepository extends Repository
{
    private static $path = '/brand';

    public static function model()
    {
        return Brand::class;
    }

    public static function storeByRequest(BrandRequest $request)
    {
        $mediaId = null;
        if ($request->hasFile('image')) {
            $media = MediaRepository::storeByRequest($request->image, self::$path);
            $mediaId = $media->id;
        }
        $create = self::create([
            'title' => $request->title,
            'media_id' => $mediaId
        ]);

        return $create;
    }

    public static function updateByRequest(BrandRequest $request, Brand $brand): Brand
    {
        $media = null;
        if ($request->hasFile('image')) {
            $media = MediaRepository::updateOrCreateByRequest(
                $request->image,
                self::$path,
                'Image',
                $brand->media
            );
        }
        self::update($brand, [
            'title' => $request->title,
            'media_id' => $media ? $media->id : $brand->media_id,
        ]);

        return $brand;
    }
}
