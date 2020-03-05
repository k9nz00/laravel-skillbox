<?php

namespace App\Http\Controllers\Post;

use App\Helpers\MessageHelpers;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Notifications\PostNotafication\ChangePostStateNotification;
use App\User;
use App\Validators\PostValidator;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Auth;
use Illuminate\Validation\ValidationException;
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
        $posts = Post::with([
            'tags' => function ($query) {
                $query->select('name');
            },
        ])->latest()->get(['title', 'slug', 'shortDescription', 'created_at']);
        return view('post.list', compact('posts'));
    }

    /**
     * Показ одной статьи
     *
     * @param Post $post
     * @return Factory|View
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Страница создания статьи
     *
     * @return RedirectResponse|View
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Сохраняет новую статью
     *
     * @param Request $request
     * @param PostValidator $postValidator
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store(Request $request, PostValidator $postValidator)
    {
        $validatedData = $postValidator->postValidate($request, null);
        $post = Post::create(array_merge($validatedData, [
            'publish'  => (boolean)$request->publish,
            'owner_id' => Auth::id(),
        ]));

        $subjectMessage = 'Статья ' . $post->title . ' была создана';
        //Отправка почного уведомления администратору сайта
        User::getAdmin()->notify(new ChangePostStateNotification($post, $subjectMessage,
            ChangePostStateNotification::POST_TYPE_STATUS_CREATE));

        $tagsIds = [];
        $tagsToAttach = explode(', ', $request->tags);
        foreach ($tagsToAttach as $tagToAttach) {
            $tagToAttach = Tag::firstOrCreate(['name' => $tagToAttach]);
            $tagsIds[] = $tagToAttach->id;
        }
        $post->tags()->sync($tagsIds);

        $messageAboutCreate = 'Статья ' . $post->title . ' успешно создана';
        MessageHelpers::flashMessage($messageAboutCreate);

        return redirect()->route('post.index');
    }

    /**
     * Редактирование статьи
     *
     * @param Post $post
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('post.edit', compact('post'));
    }

    /**
     * Обновление статьи
     *
     * @param Request $request
     * @param Post $post
     * @param PostValidator $postValidator
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Post $post, PostValidator $postValidator)
    {
        $validatedData = $postValidator->postValidate($request, $post);
        $post->update(array_merge($validatedData, [
            'publish' => (boolean)$request->publish,
        ]));

        $subjectMessage = 'Статья ' . $post->title . ' была обновлена';
        //Отправка почного уведомления администратору сайта
        User::getAdmin()->notify(new ChangePostStateNotification($post, $subjectMessage,
            ChangePostStateNotification::POST_TYPE_STATUS_UPDATE));

        $existTagsFromPost = $post->tags->keyBy('name');
        $tagsForPost = collect(explode(', ', request('tags')))
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

        $messageAboutCreate = 'Статья ' . $post->title . ' успешно обновлена';
        MessageHelpers::flashMessage($messageAboutCreate, 'info');

        return redirect()->route('post.show', $post->slug);
    }

    /**
     * Удаление статьи
     *
     * @param Post $post
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $this->authorize('update', $post);
        if ($post->delete()) {
            $messageAboutCreate = 'Статья ' . $post->title . ' удалена';
            MessageHelpers::flashMessage($messageAboutCreate, 'warning');

            $subjectMessage = 'Статья ' . $post->title . ' была удалена';
            //Отправка почного уведомления администратору сайта
            User::getAdmin()->notify(new ChangePostStateNotification($post, $subjectMessage,
                ChangePostStateNotification::POST_TYPE_STATUS_DELETE));

            return redirect(route('post.index'));
        } else {
            return back()->withErrors('Не удалось удалить статью');
        }
    }
}
