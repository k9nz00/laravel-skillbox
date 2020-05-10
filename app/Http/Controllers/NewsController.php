<?php

namespace App\Http\Controllers;

use App\Models\News;
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
        $news = News::latest()->get();

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
        return view('news.show', compact('news'));
    }
}
