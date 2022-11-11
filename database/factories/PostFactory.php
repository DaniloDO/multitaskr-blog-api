<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = fake()->sentence();
        return [
            'uid' => fake()->uuid(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(1),
            'content' => fake()->randomHtml(2,3),
            'image' => fake()->imageUrl(),
            'published_at' => strtotime('+7 days'),
            'user_id' => function() {
                return User::factory()->create()->id;
            }
        ];
    }
}
