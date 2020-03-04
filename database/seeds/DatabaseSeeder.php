<?php

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
        // $this->call(UsersTableSeeder::class);

        factory(App\User::class, 5)->create()->each(function($user) {
            $user->posts()->saveMany(factory(App\Models\Post::class, 10)->make());
        });
    }
}
