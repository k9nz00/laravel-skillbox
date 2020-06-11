<?php

namespace App\Services;

use App\Helpers\MessageHelpers;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Services\ExternalServices\Pushall;
use Auth;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class PostServices
{

    /**
     * @var TagServices
     */
    protected $tagServices;

    /**
     * PostServices constructor.
     */
    public function __construct()
    {
        $this->tagServices = new TagServices();
    }


    /**
     * Сохраняет новый пост в базе данных.
     * Возвращает объект сохраненного поста
     *
     * @param StorePostRequest $storePostRequest
     * @return Post
     */
    public function storePost(StorePostRequest $storePostRequest): Post
    {
        $validatedData = $storePostRequest->validated();
        $post = Post::create(array_merge($validatedData, [
            'publish' => (boolean)$storePostRequest->publish,
            'owner_id' => Auth::id(),
        ]));

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
    public function updatePost(UpdatePostRequest $updatePostRequest, Post $post): Post
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
     * @return void
     */
    public function addTagsToPost(FormRequest $formRequest, Post $post): void
    {
        $tagsIds = $this->tagServices->getTagIdsForAttach($formRequest);
        $post->tags()->sync($tagsIds);
    }

    /**
     * Обновляет посты у поста
     *
     * @param FormRequest $formRequest
     * @param Post $post
     * @return void
     */
    public function updateTagsToPost(FormRequest $formRequest, Post $post): void
    {
        $tagsIds = $this->tagServices->getTagIdsForUpdate($formRequest, $post);
        $post->tags()->sync($tagsIds);
    }

    /**
     * Отправка уведомления на pushall
     * @param string $body
     * @param string $title
     * @return void
     */
    public function sendNotificationsViaPushall(string $body, string $title = 'На сайте была создана новая статья') : void
    {
        $pushall = app(Pushall::class);

        /** @var Pushall $pushall */
        $pushall->send($title, $body);
    }
}
