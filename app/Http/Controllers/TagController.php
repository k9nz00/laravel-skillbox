<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagController extends Controller
{
    public function index(Tag $tag)
    {
        $items = $tag
            ->load([
                'posts' => function ($query) {
                    return $query->where('publish', '=', 1);
                },
                'news',
            ]);

        $tagName = $tag->name;
        $items = array_merge($items->posts->toArray(), $items->news->toArray());

        return view('tag.list', compact('tagName', 'items'));
    }
}
