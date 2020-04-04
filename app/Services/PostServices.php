<?php

namespace App\Services;

use App\Helpers\MessageHelpers;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Notifications\PostNotafication\ChangePostStateNotification;
use App\Services\ExternalServices\Pushall;
use App\User;
use Auth;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class PostServices
{
    /**
     * Сохраняет новый пост в базе данных.
     * Возвращает объект сохраненного поста
     *
     * @param StorePostRequest $storePostRequest
     * @return Post|Model
     */
    public function storePost(StorePostRequest $storePostRequest)
    {
        $validatedData = $storePostRequest->validated();
        $post = Post::create(array_merge($validatedData, [
            'publish'  => (boolean)$storePostRequest->publish,
            'owner_id' => Auth::id(),
        ]));

        //отправка уведомления на pushall при создании статьи
        $pushall = app(Pushall::class);
        /** @var Pushall $pushall */
        $pushall->send('На сайте была создана новая статья', $post->title);
        return $post;
    }

    /**
     * Обновляет существующий пост в базе данных.
     * Возвращает объект обновленного поста
     *
     * @param UpdatePostRequest $updatePostRequest
     * @param Post $post
     * @return Post
     */
    public function updatePost(UpdatePostRequest $updatePostRequest, Post $post)
    {
        $validatedData = $updatePostRequest->validated();
        $post->update(array_merge($validatedData, [
            'publish' => (boolean)$updatePostRequest->publish,
        ]));
        return $post;
    }

    /**
     * @param Post $post
     * @return bool|null
     * @throws Exception
     */
    public function destroyPost(Post $post)
    {
        $postIsDeleted = $post->delete() ?? false;
        if ($postIsDeleted) {
            $messageAboutDelete = 'Статья ' . $post->title . ' удалена';
            MessageHelpers::flashMessage($messageAboutDelete, 'warning');
            return $postIsDeleted;
        }
    }

    /**
     * Добавляет новые теги к посту
     *
     * @param FormRequest $formRequest
     * @param Post $post
     * @return Post
     */
    public function addTagsToPost(FormRequest $formRequest, Post $post)
    {
        $tagsIds = [];
        $tagsToAttach = explode(', ', $formRequest->tags);
        foreach ($tagsToAttach as $tagToAttach) {
            $tagToAttach = Tag::firstOrCreate(['name' => $tagToAttach]);
            $tagsIds[] = $tagToAttach->id;
        }
        $post->tags()->sync($tagsIds);
        return $post;
    }

    /**
     * Обновляет посты у поста
     *
     * @param FormRequest $formRequest
     * @param Post $post
     * @return Post
     */
    public function updateTagsToPost(FormRequest $formRequest, Post $post)
    {
        $existTagsFromPost = $post->tags->keyBy('name');
        $tagsForPost = collect(explode(', ', $formRequest->tags))
            ->keyBy(function ($item) {
                return $item;
            });
        $tagsIdsForSync = $existTagsFromPost
            ->intersectByKeys($tagsForPost)
            ->pluck('id')
            ->toArray();

        $tagsToAttach = $tagsForPost->diffKeys($existTagsFromPost);
        foreach ($tagsToAttach as $tagToAttach) {
            $tagToAttach = Tag::firstOrCreate(['name' => $tagToAttach]);
            $tagsIdsForSync[] = $tagToAttach->id;
        }
        $post->tags()->sync($tagsIdsForSync);
        return $post;
    }
}
