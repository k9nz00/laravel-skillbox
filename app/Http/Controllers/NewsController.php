<?php

namespace App\Http\Controllers;

use App\Models\Interfaces\Contentable;
use App\Models\News;
use Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Просмотр списка новостей
     *
     * @return Application|Factory|View
     */
    public function index()
    {

        //написать метод выборки данных и разместить его в модели
        $news = Cache::tags([News::CACHE_TAGS, News::CONTENT])
            ->remember(News::CACHE_TAGS, 3600 * 24, function () {
                return News::with(['tags', 'owner'])
                    ->latest()
                    ->paginate(config('paginate.perPage'), ['*'], 'newsPage');
            });

        return view('news.list', compact('news'));
    }

    /**
     * Display the specified resource.
     *
     * @param News $news
     * @return View
     */
    public function show(News $news)
    {
        $news = Cache::tags(['post'])->remember('newsItem|' . $news->id, 3600 * 24, function () use ($news) {
            $news->takeCommentsWithOwners(['id', 'name', 'email']);
            return $news;
        });
        return view('news.show', compact('news'));
    }
}
