<?php

use App\Models\Post;
use App\Models\Tag;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * написать комментраий
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create()
            ->each(function (User $user) {
                $user->posts()->saveMany(factory(Post::class, 10)->make());
                $posts = $user->posts;
                $tags = Tag::all()->pluck('id')->toArray();
                foreach ($posts as $post) {
                    $randomTadsId = Arr::random($tags, rand(1, 3));
                    $post->tags()->sync($randomTadsId);
                }
            });
    }
}
