<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;



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

        $posts = $items->posts->toArray();
        $news = $items->news->toArray();

        foreach ($posts as &$post)
        {
            $post['type'] = 'posts';
        }
        foreach ($news as &$newsItem)
        {
            $newsItem['type'] = 'news';
        }

        $items = array_merge($posts, $news);
        $perPage = config('paginate.perPage');
        $offset = null;
        if (isset($_GET['page'])){
            $offset = ($_GET['page'] -1) * $perPage;
        } else {
            $offset = null;
        }
        $total = count($items);

        $items = array_slice($items, $offset, $perPage);

        $items = new LengthAwarePaginator($items, $total, $perPage);
        $items->withPath('/posts/tags/'.$tag->name);

        return view('tag.list', compact('tagName', 'items'));
    }
}
