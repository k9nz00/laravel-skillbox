<?php

namespace App\Policies;

use App\Models\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    private function baseAllowAccess(User $user, Post $post)
    {
        $access = false;
        if ($user->isAdmin() || $post->owner_id == $user->id) {
            $access = true;
        }
        return $access ?
            Response::allow() :
            Response::deny('У вас нет прав для управления этим постом');
    }

    /**
     * Проверка на наличие прав для редактрования поста
     *
     * @param User $user
     * @param Post $post
     * @return Response
     */
    public function update(User $user, Post $post)
    {
        return $this->baseAllowAccess($user, $post);
    }

    /**
     * Проверка на наличие прав для удаления поста
     *
     * @param User $user
     * @param Post $post
     * @return Response
     */
    public function delete(User $user, Post $post)
    {
        return $this->baseAllowAccess($user, $post);
    }

    /**
     * Проверка на наличие прав для редактирования статьи
     * @param Post $post
     * @param User $user
     * @return bool
     */
    public function isAccessToEdit(?User $user, Post $post)
    {
        $access = false;
        if (isset($user) && ($post->owner_id == $user->id || $user->isAdmin())) {
            $access = true;
        }
        return $access;
    }

}
