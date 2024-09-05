<?php

namespace App\Repositories;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerRepository extends Repository
{
    public static $path = '/banner';

    public static function model()
    {
        return Banner::class;
    }
    public static function storeByRequest(Request $request)
    {
        $media = MediaRepository::storeByRequest(
            $request->image,
            self::$path,
            'Image'
        );

        return self::create([
            'title' => $request->title,
            'media_id' => $media->id,
            'url' => $request->url,
            'status' => $request->status ?? 1
        ]);
    }

    public static function updateByRequest(Request $request, Banner $banner)
    {
        $mediaId = $banner->media_id;
        if ($request->hasFile('image')) {
            $media = MediaRepository::updateOrCreateByRequest(
                $request->image,
                self::$path,
                'Image',
                $banner->media
            );
            $mediaId = $media->id;
        }

        self::update($banner, [
            'title' => $request->title,
            'media_id' => $mediaId,
            'url' => $request->url,
            'status' => $request->status ?? 1
        ]);
    }
}
