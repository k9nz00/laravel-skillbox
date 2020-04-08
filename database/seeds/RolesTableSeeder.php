<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Создание минимального количества ролей для приложения
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'registered']);
    }
}
