<?php

use App\Models\Role;
use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user = User::create([
           'name' => 'Andrey',
           'email' => 'k9nz00@yandex.ru',
           'email_verified_at' => now(),
           'password' => Hash::make('admin'),
           'remember_token' => Str::random(10),
       ]);

       $adminRole = Role::firstOrCreate(['name' => 'admin']);
       $user->roles()->sync([$adminRole->id]);
    }
}
