<?php

namespace App\Repositories;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaRepository extends Repository
{
    public static function model()
    {
        return Media::class;
    }
    public static function storeByRequest(UploadedFile $file, string $path, string $type = null): Media
    {
        $path = Storage::put('/' . trim($path, '/'), $file, 'public');
        $extension = $file->extension();
        if (!$type) {
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'Image' : $extension;
        }

        return self::create([
            'type' => $type,
            'src' =>  'public/storage/' . $path,
        ]);
    }

    public static function updateByRequest(UploadedFile $file, string $path, string $type = null, Media $media): Media
    {
        $path = Storage::put('/' . trim($path, '/'), $file, 'public');
        $extension = $file->extension();
        if (!$type) {
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'Image' : $extension;
        }

        if (Storage::exists($media->src)) {
            Storage::delete($media->src);
        }

        self::update($media, [
            'type' => $type,
            'src' =>  'public/storage/' . $path,
        ]);
        return $media;
    }

    public static function updateOrCreateByRequest(UploadedFile $file, string $path, string $type = null, $media = null): Media
    {
        $src = Storage::put('/' . trim($path, '/'), $file, 'public');
        if ($media && Storage::exists($media->src)) {
            Storage::delete($media->src);
        }
        $extension = $file->extension();
        if (!$type) {
            $type = in_array($extension, ['jpg', 'png', 'jpeg', 'gif']) ? 'Image' : $extension;
        }
        return self::query()->updateOrCreate([
            'id' => $media?->id ?? 0,
        ], [
            'type' => $type,
            'src' => 'public/storage/' . $src,
            'extension' => $extension,
            'path' => $path,
        ]);
    }
}
