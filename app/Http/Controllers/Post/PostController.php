<?php

namespace App\Http\Controllers\Post;

use App\Helpers\MessageHelpers;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Список всех постов
     *
     * @return Factory|View
     */
    public function index()
    {
        //разобраться как выбирать отпределеные столбцы поста + теги
        $posts = Post::with('tags')->latest()->get();
        return view('post.list', compact('posts'));
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Factory|View
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Сохраняет новую статью
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'slug'             => 'required|alpha_dash|unique:posts,slug',
            'title'            => 'required|min:5|max:100',
            'shortDescription' => 'required|max:255',
            'body'             => 'required',
        ]);

        $post = Post::create(array_merge($validatedData, [
            'publish' => (boolean)$request->publish,
        ]));

        $tagsIds = [];
        $tagsToAttach = explode(', ', $request->tags);
        foreach ($tagsToAttach as $tagToAttach) {
            $tagToAttach = Tag::firstOrCreate(['name' => $tagToAttach]);
            $tagsIds[] = $tagToAttach->id;
        }
        $post->tags()->sync($tagsIds);

        $messageAboutCreate = 'Статья '. $post->title . ' успешно создана';
        MessageHelpers::flashMessage($messageAboutCreate);

        return redirect()->route('post.index');
    }

    /**
     * Редактирование статьи
     *
     * @param Post $post
     * @return Factory|View
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Обновление статьи
     *
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $this->validate($request, [
            'slug'             => 'required|alpha_dash',
            'title'            => 'required|min:5|max:100',
            'shortDescription' => 'required|max:255',
            'body'             => 'required',
        ]);

        $post->update(array_merge($validatedData, [
            'publish' => (boolean)$request->publish,
        ]));

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

        $messageAboutCreate = 'Статья '. $post->title . ' успешно обновлена';
        MessageHelpers::flashMessage($messageAboutCreate, 'info');

        return redirect()->route('post.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        if ($post->delete()) {
            $messageAboutCreate = 'Статья '. $post->title . ' удалена';
            MessageHelpers::flashMessage($messageAboutCreate, 'warning');

            return redirect(route('post.index'));
        } else {
            return back()->withErrors('Не удалось удалить статью');
        }
    }
}
