<?php

namespace App\Http\Controllers\Admin\Post;

use App\Helpers\MessageHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostServices;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AdminPostController extends Controller
{
    /**
     * Список всех постов
     *
     * @return View
     */
    public function index()
    {
        $posts = Post::latest()
            ->simplePaginate(config('paginate.perPageForAdminsPages'), ['*']);
        $postsCount = Post::count();
        return view('admin.post.index', compact('posts', 'postsCount'));
    }

    /**
     * Создание поста из админки
     *
     * @return View
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Сохранение поста из админки
     *
     * @param StorePostRequest $storePostRequest
     * @param PostServices $postServices
     * @return RedirectResponse
     */
    public function store(StorePostRequest $storePostRequest, PostServices $postServices)
    {
        $post = $postServices->storePost($storePostRequest);
        $postServices->addTagsToPost($storePostRequest, $post);
        $postServices->sendNotificationsViaPushall($post->title); //телом push-уведомления является заголовок статьи

        $messageAboutCreate = 'Статья ' . $post->title . ' успешно создана';
        MessageHelpers::flashMessage($messageAboutCreate);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Редактирование поста из админки
     *
     * @param Post $post
     * @return View
     */
    public function edit(Post $post)
    {
        return view('admin.post.edit', compact('post'));
    }

    /**
     * Обновление поста из админки
     *
     * @param UpdatePostRequest $updatePostRequest
     * @param Post $post
     * @param PostServices $postServices
     * @return RedirectResponse
     */
    public function update(UpdatePostRequest $updatePostRequest, Post $post, PostServices $postServices)
    {
        $updatedPost = $postServices->updatePost($updatePostRequest, $post);
        $postServices->updateTagsToPost($updatePostRequest, $updatedPost);

        $messageAboutUpdate = 'Статья ' . $updatedPost->title . ' успешно обновлена';
        MessageHelpers::flashMessage($messageAboutUpdate, 'info');

        return redirect()->route('admin.posts.index', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @param PostServices $postServices
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Post $post, PostServices $postServices)
    {
        $isDeleted = $postServices->destroyPost($post);
        if ($isDeleted) {
            return redirect(route('admin.posts.index'));
        } else {
            return back()->withErrors('Не удалось удалить статью ' . $post->title);
        }
    }
}
