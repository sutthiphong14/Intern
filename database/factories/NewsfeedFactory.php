<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Newsfeed>
 */
class NewsfeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name'=>fake()->name(),
            'description'=>fake()->text(),
            'category_id'=>rand(1,4), // ใช้ id ที่มีอยู่ใน category_models
            'link'=>fake()->text(),
            'status'=>rand(0,1)
        ];
    }
}
