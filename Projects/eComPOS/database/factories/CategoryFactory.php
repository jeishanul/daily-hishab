<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'media_id' => Media::factory()->create(),
            'name' => $this->faker->name,
            'slug' => Str::slug($this->faker->name)
        ];
    }
}
