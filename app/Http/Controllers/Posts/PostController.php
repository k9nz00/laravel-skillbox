<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Просмотр всех задач
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::all();
        $data = [
            'posts' => $posts,
        ];
        return view('posts.index', $data);
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|min:3',
            'body'  => 'required',
        ]);

        Post::create([
            'title' => request('title'),
            'body'  => request('body'),
            'slug'  => Str::slug(request('title')),
        ]);

        return redirect(route('posts'));
    }
}
