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
        $this->call([
            RolesTableSeeder::class,
            TagsSeeder::class,
            NewsSeeder::class,
            //AdminSeeder::class, //админ создается в CreateRoleUserTable
            UsersTableSeeder::class,
            UsersFeedbackSeeder::class,
        ]);
    }
}
