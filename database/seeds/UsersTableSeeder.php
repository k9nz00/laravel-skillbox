<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Создание 5 пользователей и у каждого по 10 постов
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create()->each(function($user) {
            $user->posts()->saveMany(factory(App\Models\Post::class, 10)->make());
        });
    }
}
