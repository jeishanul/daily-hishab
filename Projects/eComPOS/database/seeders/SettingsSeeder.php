<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::truncate();
        cache()->forget('settings');
        $data = [
            'site_title' => 'eCom POS',
            'logo_path' => Media::factory()->create([
                'src' => 'public/logo/logo.png',
                'path' => 'settings/',
            ])->src,
            'small_logo_path' => Media::factory()->create([
                'src' => 'public/logo/small-logo.png',
                'path' => 'settings/',
            ])->src,
            'favicon_path' => Media::factory()->create([
                'src' => 'public/logo/small-logo.png',
                'path' => 'settings/',
            ])->src,
            'dark_logo_path' => Media::factory()->create([
                'src' => 'public/logo/dark-logo.png',
                'path' => 'settings/',
            ])->src,
            'big_sale_banner_path' => Media::factory()->create([
                'src' => 'public/banners/big_sale.png',
                'path' => 'settings/',
            ])->src,
            'all_products_banner_path' => Media::factory()->create([
                'src' => 'public/banners/top-banner.jpg',
                'path' => 'settings/',
            ])->src,
            'currency_id' => 1,
            'currency_symbol' => '$',
            'currency_code' => 'USD',
            'currency_position' => 'Prefix',
            'date_format' => 'd-m-Y',
            'date_with_time' => 'Enable',
            'address' => 'Dhaka, Bangladesh',
            'email' => 'support@razinsoft.com',
            'phone' => '+8801963953998',
            'developed_by' => 'Razinsoft',
            'copyright_text' => 'Copyright 2024',
            'about_us' => 'Razinsoft',
            'copyright_url' => 'https://razinsoft.com',
            'dark_mode' => 0,
            'direction' => 'ltr',
            'lang' => 'en',
            'primary_color' => '#06D001',
            'secondary_color' => '#E8FFE4',
            'barcode_digits' => 8,
            'home_delivery_description' => 'Home Delivery',
            'payment_security_description' => '100% Secure Payment',
            'support_description' => '24/7 Support',
        ];

        foreach ($data as $key => $value) {
            Settings::create(
                [
                    'key' => $key,
                    'value' => $value
                ]
            );
        }
    }
}
