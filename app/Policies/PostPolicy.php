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
        return $access ? Response::allow() : Response::deny('У вас нет прав для управления этой статьей');
    }

    /**
     * Проверка на наличие прав для редактрования статьи
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
     * Determine whether the user can delete the post.
     *
     * @param User $user
     * @param Post $post
     * @return Response
     */
    public function delete(User $user, Post $post)
    {
        return $this->baseAllowAccess($user, $post);
    }

}