<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Blog;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=> fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->text(1000),
            'featured_image' => null,
            'status' => Blog::STATUS_PUBLISHED,
            'reading_time' => fake()->numberBetween(0, 60),
            'view_count' => fake()->numberBetween(0, 1000),
            'published_at' => now(),
            'meta_title' => fake()->sentence(),
            'meta_description' => fake()->sentence(),
            'user_id' => User::factory(), // Automatically creates a user
        ];
    }
}
