<?php

namespace Tests\Feature;

use App\Models\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    //пользователь не обладающий правами админа не может заходить в админ-панель
    public function testNotAdminCanNotEnterAdminPage()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create());
        $this->get(route('admin'))->assertRedirect(route('home'));
    }

    //пользователь с правами администратора может заходить в админ-панель
    public function testAdminCanEnterAdminPage()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create());
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $user->roles()->sync([$adminRole->id]);
        $this->get(route('admin'))->assertStatus(200);
    }
}
