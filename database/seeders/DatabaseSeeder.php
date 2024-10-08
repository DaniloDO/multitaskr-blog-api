<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $categories = Category::factory(5)->create();

        User::factory(10)->create()->each(function($user) use($categories) {
            $posts = Post::factory(10)->create([
                'user_id' => $user->id
            ]);

            $posts->each(function($post) use($categories, $user) {
                $post->categories()->attach($categories->random()->id);
                $comment = Comment::Factory(2)->create([
                    'user_id' => rand(1, 10),
                    'post_id' => $post->id
                ]);
            });
            
        });
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
