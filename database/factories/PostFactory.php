<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->realText(40);
        return [
            'title' => $title,
            'slug' => \Str::slug($title),
            'thumbnail' => fake()->imageUrl,
            'body' => fake()->realText(19000),
            'active' =>fake()->boolean,
            'published_at' =>fake()->dateTime,
            'user_id' => 1,
            
        ];
    }
}
