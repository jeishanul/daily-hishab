<?php

namespace App\Repositories;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\support\Str;

class CategoryRepository extends Repository
{
    public static $path = '/category';

    public static function model()
    {
        return Category::class;
    }

    public static function storeByRequest(CategoryRequest $request)
    {
        $mediaId = null;
        if ($request->hasFile('image')) {
            $media = MediaRepository::storeByRequest(
                $request->image,
                self::$path,
                'Image'
            );
            $mediaId = $media->id;
        }

        return self::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'media_id' => $mediaId,
        ]);
    }

    public static function updateByRequest(CategoryRequest $request, Category $category): Category
    {
        $mediaId = null;
        if ($request->hasFile('image')) {
            $media = MediaRepository::updateOrCreateByRequest(
                $request->image,
                self::$path,
                'Image',
                $category->media
            );
            $mediaId = $media->id;
        }

        self::update($category, [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'media_id' => $mediaId ? $mediaId : $category->media_id,
        ]);
        return $category;
    }

    public static function importByRequest(Request $request)
    {
        $csv = file($request->file);
        foreach ($csv as $key => $data) {
            $csvArr = explode(',', $data);
            $category = CategoryRepository::query()->where('name', trim($csvArr[1]))->first();
            if ($key != 0) {
                self::create([
                    'name' => $csvArr[0],
                    'category_id' => $category?->id
                ]);
            }
        }
    }
}
