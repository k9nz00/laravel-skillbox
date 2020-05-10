<?php

namespace App\Http\Controllers\Post;

use App\Helpers\MessageHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Notifications\PostNotafication\ChangePostStateNotification;
use App\Services\PostServices;
use App\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Auth;
use Illuminate\View\View;
use Gate;

class PostController extends Controller
{
    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth',
            [
                //На весь контроллер действует middleWare, кроме методов index и show
                'except' => ['index', 'show'],
            ]);
    }

    /**
     * Список всех постов
     *
     * @return Factory|View
     */
    public function index()
    {
        $posts = Post::getLastPublishedArticlesWithTags();
        return view('post.list', compact('posts'));
    }

    /**
     * Показ одной статьи
     *
     * @param Post $post
     * @return View
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Страница создания статьи
     *
     * @return View
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Сохраняет новую статью
     *
     * @param StorePostRequest $storePostRequest
     * @param PostServices $postServices
     * @return RedirectResponse|Redirector
     */
    public function store(StorePostRequest $storePostRequest, PostServices $postServices)
    {
        $post = $postServices->storePost($storePostRequest);
        $postServices->addTagsToPost($storePostRequest, $post);
        $postServices->sendNotificationsViaPushall($post->title); //телом push-уведомления является заголовок статьи

        //Отправка почтового уведомления администратору сайта
        $subjectMessage = 'Статья ' . $post->title . ' была создана';
        User::getAdmin()->notify(new ChangePostStateNotification($post, $subjectMessage,
            ChangePostStateNotification::POST_TYPE_STATUS_CREATE));

        $messageAboutCreate = 'Статья ' . $post->title . ' успешно создана';
        MessageHelpers::flashMessage($messageAboutCreate);

        return redirect()->route('posts.index');
    }

    /**
     * Редактирование статьи
     *
     * @param Post $post
     * @return View
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('post.edit', compact('post'));
    }

    /**
     * Обновление статьи
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

        //Отправка почного уведомления администратору сайта
        $subjectMessage = 'Статья ' . $updatedPost->title . ' была обновлена';
        User::getAdmin()->notify(new ChangePostStateNotification($post, $subjectMessage,
            ChangePostStateNotification::POST_TYPE_STATUS_UPDATE));

        return redirect()->route('posts.show', $post->slug);
    }

    /**
     * Удаление статьи
     *
     * @param Post $post
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Post $post, PostServices $postServices)
    {
        $this->authorize('update', $post);
        $isDeleted = $postServices->destroyPost($post);
        if ($isDeleted) {
            //Отправка почного уведомления администратору сайта
            $subjectMessage = 'Статья ' . $post->title . ' была удалена';
            User::getAdmin()->notify(new ChangePostStateNotification($post, $subjectMessage,
                ChangePostStateNotification::POST_TYPE_STATUS_DELETE));

            return redirect(route('posts.index'));
        } else {
            return back()->withErrors('Не удалось удалить статью');
        }
    }
}
