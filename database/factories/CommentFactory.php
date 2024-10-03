<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uid' => fake()->uuid(),
            'content' => fake()->paragraph(1),
            'published_at' => strtotime('+7 days'),
            'user_id' => function() {
                return User::factory()->create()->id;
            },
            'post_id' => function() {
                return Post::factory()->create()->id;
            }
        ];
    }
}
