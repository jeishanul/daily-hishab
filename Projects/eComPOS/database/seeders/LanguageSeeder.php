<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::truncate();
        $languages = [
            [
                'title' => 'English',
                'name' => 'en',
            ],
            [
                'title' => 'Arabic',
                'name' => 'ar',
            ],
            [
                'title' => 'Bangla',
                'name' => 'bn',
            ]
        ];

        foreach ($languages as $language) {
            Language::create([
                'title' => $language['title'],
                'name' => $language['name'],
                'media_id' => Media::factory()->create([
                    'src' => 'public/flags/' . $language['name'] . '.jpg',
                ])->id
            ]);
        }
    }
}
