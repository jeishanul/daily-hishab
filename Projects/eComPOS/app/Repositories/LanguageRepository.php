<?php

namespace App\Repositories;

use App\Http\Requests\LanguageRequest;
use App\Models\Language;

class LanguageRepository extends Repository
{
    public static $path = '/languages';
    public static function model()
    {
        return Language::class;
    }

    public static function checkFileExitsOrNot(array $fileNames)
    {
        foreach ($fileNames as $name) {
            if (!self::isNameExists($name)) {
                self::create([
                    'title' => $name,
                    'name' => $name,
                ]);
            }
        }
    }

    public static function storeByRequest(LanguageRequest $request)
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

        $filePath = base_path("lang/$request->name.json");

        $jsonData = file_get_contents(public_path('web/emptyLanguage.json'));

        file_put_contents($filePath, $jsonData);

        return self::create([
            'title' => $request->title,
            'name' => $request->name,
            'media_id' => $mediaId,
        ]);
    }

    public static function updateByRequest(Language $language, LanguageRequest $request, $filePath): Language
    {
        $mediaId = null;
        if ($request->hasFile('image')) {
            $media = MediaRepository::updateOrCreateByRequest(
                $request->image,
                self::$path,
                'Image',
                $language->media
            );
            $mediaId = $media->id;
        }

        $keys = $request->key;
        $values = $request->value;
        $newData = [];
        if (!empty($keys) && !empty($values)) {
            for ($i = 0; $i < count($keys); $i++) {
                $newData[$keys[$i]] =  array_key_exists($i, $values) ? $values[$i] : '';
            }
        }

        $existingData = json_decode(file_get_contents($filePath), true);

        $updatedData = array_merge($existingData, $newData);

        file_put_contents($filePath, json_encode($updatedData, JSON_PRETTY_PRINT));

        $language->update([
            'title' => $request->title,
            'media_id' => $mediaId ? $mediaId : $language->media_id,
        ]);

        return $language;
    }

    public static function isNameExists($name)
    {
        return self::query()->where('name', $name)->exists();
    }
}
