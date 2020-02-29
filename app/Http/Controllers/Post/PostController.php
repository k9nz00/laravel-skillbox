<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
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
        $posts = Post::latest()->get(['title', 'slug', 'shortDescription', 'created_at']);
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

        Post::create(array_merge($validatedData, [
            'publish' => (boolean)$request->publish,
        ]));
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

        return redirect()->route('post.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post)
    {
        if ($post->delete()) {
            return redirect(route('post.index'));
        } else {
            return back()->withErrors('Не удалось удалить статью');
        }


    }
}
