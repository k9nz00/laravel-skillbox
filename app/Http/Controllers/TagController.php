<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Tag $tag)
    {
        $posts = $tag
            ->load([
                'posts' => function ($query) {
                    return $query->where('publish', '=', 1);
                },])
            ->posts;

        return view('post.list', compact('posts'));
    }
}
