<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class TagController extends Controller
{
    /**
     * Страница тега, где отображены новости и статьи, содержащие этот тег
     * Сделал кастомный пагинатор.
     * Не нравится реализация - могуь появиться проблемы при большои количестве загружаемый данных.
     * Спросить у Михаила при проверке о более правильном подходе
     * (и вообше переписать весь экшн. Мне не нравится)
     *
     * @param Tag $tag
     * @return View
     */
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
