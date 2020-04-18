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
            ->posts()
            ->where('publish', '=', '1') //параметр value должен быть строкой - иначе не работает
            ->get();
        return view('post.list', compact('posts'));
    }
}
