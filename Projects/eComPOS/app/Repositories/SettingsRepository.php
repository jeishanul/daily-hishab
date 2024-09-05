<?php

namespace App\Repositories;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsRepository extends Repository
{
    private static $path = '/settings';

    public static function model()
    {
        return Settings::class;
    }

    public static function updateByRequest(Request $request)
    {
        $siteLogoPath = getSettings('logo_path');
        if ($request->hasFile('site_logo')) {
            $siteLogo = (new MediaRepository())->storeByRequest(
                $request->site_logo,
                self::$path,
                'Image'
            );
            $siteLogoPath = $siteLogo->src;
        }

        $smallLogoPath = getSettings('small_logo_path');
        if ($request->hasFile('small_logo')) {
            $smallLogo = (new MediaRepository())->storeByRequest(
                $request->small_logo,
                self::$path,
                'Image'
            );
            $smallLogoPath = $smallLogo->src;
        }

        $faviconPath = getSettings('favicon_path');
        if ($request->hasFile('favicon')) {
            $favicon = (new MediaRepository())->storeByRequest(
                $request->favicon,
                self::$path,
                'Image'
            );
            $faviconPath = $favicon->src;
        }

        $siteDarkLogoPath = getSettings('dark_logo_path');
        if ($request->hasFile('dark_logo')) {
            $dark_logo = (new MediaRepository())->storeByRequest(
                $request->dark_logo,
                self::$path,
                'Image'
            );
            $siteDarkLogoPath = $dark_logo->src;
        }

        $bigSaleBannerPath = getSettings('big_sale_banner_path');
        if ($request->hasFile('big_sale_banner')) {
            $big_sale_banner = (new MediaRepository())->storeByRequest(
                $request->big_sale_banner,
                self::$path,
                'Image'
            );
            $bigSaleBannerPath = $big_sale_banner->src;
        }

        $allProductsBannerPath = getSettings('all_products_banner_path');
        if ($request->hasFile('all_products_banner')) {
            $all_products_banner = (new MediaRepository())->storeByRequest(
                $request->all_products_banner,
                self::$path,
                'Image'
            );
            $allProductsBannerPath = $all_products_banner->src;
        }
        

        
        $request['logo_path'] = $siteLogoPath;
        $request['dark_logo_path'] = $siteDarkLogoPath;
        $request['small_logo_path'] = $smallLogoPath;
        $request['favicon_path'] = $faviconPath;
        $request['big_sale_banner_path'] = $bigSaleBannerPath;
        $request['all_products_banner_path'] = $allProductsBannerPath;

        foreach ($request->all() as $key => $value) {
            $settings = self::query()->where('key', $key)->first();
            if ($settings) {
                self::update($settings, [
                    'value' => $value
                ]);
            }
        }
    }
}
