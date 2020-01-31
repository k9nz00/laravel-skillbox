<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Просмотр статьи
     *
     * @param Post $post
     * @return Factory|View
     */
    public function index(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Создание статьи
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Сохранение статьи
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        if ($request->method() == 'POST') {
            if (isset($request->publish) && $request->publish == 'on' ){
                $request->publish = 1;
            } else{
                $request->publish = 0;
            }

            $this->validate($request, [
                'slug'             => 'required|alpha_dash|unique:posts,slug',
                'title'            => 'required|min:5|max:100',
                'shortDescription' => 'required|max:255',
                'body'             => 'required',
            ]);

            Post::create([
                'slug'             => Str::slug($request->slug),
                'title'            => $request->title,
                'shortDescription' => $request->shortDescription,
                'body'             => $request->body,
                'publish'          => $request->publish,
            ]);
        }
        return redirect(route('home'));
    }
}
