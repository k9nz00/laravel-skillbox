<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Tag $tag)
    {
        $posts = $tag->posts()->get();
        return view('post.list', compact('posts'));

        //не могу понять как получить только опубликованные посты, у которых есть текущий тег
        //следующая конструкция не рабоатет
        //$posts = $tag->posts()->where('publish', '=', 1);
    }
}
