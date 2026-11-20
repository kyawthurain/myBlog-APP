<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $title = fake()->sentence;
        return [
            "title" => $title,
            "content" => fake()->paragraphs(3,true),
            "user_id" => 1,
            "category_id" => rand(1,6),
            "slug" => Str::slug($title),
            'featured_photo' => null,
            'reaction_count' => 0
        ];
    }
}
