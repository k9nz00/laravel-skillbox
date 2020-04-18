<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Авторизованный пользователь может создавать посты
     */
    public function testUserCanCreatePost()
    {
        //отключение перехвата ошибок
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create());
        $attributes = factory(Post::class)->raw(['owner_id' => $user]);

        $this->post(route('posts.store', $attributes), $attributes);
        $this->assertDatabaseHas('posts', $attributes);
    }

    /**
     * Неавторизованный пользователь не может создават посты
     */
    public function testGuestMayNotCreateAPost()
    {
        $this->post(route('posts.store', []))->assertRedirect(route('login'));
    }

    /**
     * Пост может редактировать только их создатель
     */
    public function testPostCanEditedOnlyByCreator()
    {
        $firstUser = factory(User::class)->create();
        $secondUser = factory(User::class)->create();

        $postForSecondUser = factory(Post::class)->create(['owner_id' => $secondUser]);

        $this->actingAs($firstUser);
        $this->get(route('posts.edit', $postForSecondUser->slug))->assertStatus(403);
    }

    /**
     * Пост может редактировать администратор
     */
    public function testPostCanEditedAdmin()
    {
        $adminUser = factory(User::class)->create();
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminUser->roles()->sync([$adminRole->id]);

        $secondUser = factory(User::class)->create();

        $postForSecondUser = factory(Post::class)->create(['owner_id' => $secondUser]);

        $this->actingAs($adminUser);
        $this->get(route('posts.edit', $postForSecondUser->slug))->assertStatus(200);
    }


}
