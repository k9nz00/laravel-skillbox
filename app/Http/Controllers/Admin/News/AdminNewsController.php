<?php

namespace App\Http\Controllers\Admin\News;

use App\Helpers\MessageHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Models\News;
use App\Services\NewsServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class AdminNewsController extends Controller
{
    /**
     * Отображение списка новостей в админке
     *
     * @return View
     */
    public function index()
    {
        $news = News::latest()
            ->with('tags')
            ->simplePaginate(config('paginate.perPageForAdminsPages'), ['id', 'title', 'created_at', 'slug']);
        $newsCount = News::count();

        return view('admin.news.index', compact('news', 'newsCount'));
    }

    /**
     * Страница создания новости через админку
     *
     * @return View
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * сохраняет новую новость
     *
     * @param StoreNewsRequest $storeNewsRequest
     * @param NewsServices $newsServices
     * @return Redirector
     */
    public function store(StoreNewsRequest $storeNewsRequest, NewsServices $newsServices)
    {
        $news = $newsServices->storeNews($storeNewsRequest);
        $newsServices->addTagsToNews($storeNewsRequest, $news);

        $messageAboutCreate = 'Новость ' . $news->title . ' успешно создана';
        MessageHelpers::flashMessage($messageAboutCreate);

        return redirect(route('admin.news.index'));
    }

    /**
     * Страница редактирования новости
     *
     * @param News $news
     * @return View
     */
    public function edit(News $news)
    {
        $newsItem = $news;
        return view('admin.news.edit', compact('newsItem'));
    }

    /**
     * Обновление новости
     *
     * @param UpdateNewsRequest $updateNewsRequest
     * @param News $news
     * @param NewsServices $newsServices
     * @return RedirectResponse
     */
    public function update(UpdateNewsRequest $updateNewsRequest, News $news, NewsServices $newsServices)
    {
        $updatedNews = $newsServices->updateNews($updateNewsRequest, $news);
        $newsServices->updateTagsToNews($updateNewsRequest, $updatedNews);

        $messageAboutUpdate = 'Новость ' . $updatedNews->title . ' успешно обновлена';
        MessageHelpers::flashMessage($messageAboutUpdate, 'info');

        return redirect()->route('admin.news.index', $updatedNews->slug);
    }

    /**
     * Удаление новости
     * @param News $news
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(News $news)
    {
        $deleted = $news->delete();
        if ($deleted) {
            $messageAboutCreate = 'Новость ' . $news->title . ' удалена';
            MessageHelpers::flashMessage($messageAboutCreate, 'danger');
            return back();
        } else {
            return back()->withErrors('Не удалось удалить статью');
        }
    }
}
