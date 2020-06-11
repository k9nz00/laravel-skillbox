<?php

namespace App\Services;

use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\News;
use App\Models\Post;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class NewsServices
{
    /**
     * Сохранение новой новости
     * @param StoreNewsRequest $storeNewsRequest
     * @return News
     */
    public function storeNews(StoreNewsRequest $storeNewsRequest): News
    {
        $validatedDataForNews = $storeNewsRequest->validated();
        $news = News::create(array_merge($validatedDataForNews, [
            'owner_id' => Auth::id(),
        ]));

        return $news;
    }

    /**
     * Обновляет существующую новость в базе данных.
     * Возвращает объект обновленной новости
     *
     * @param UpdateNewsRequest $updateNewsRequest
     * @param News $news
     * @return News
     */
    public function updateNews(UpdateNewsRequest $updateNewsRequest, News $news) : News
    {
        $validatedData = $updateNewsRequest->validated();
        $news->update($validatedData);
        return $news;
    }

    /**
     * Добавляет новые теги к новости
     *
     * @param FormRequest $formRequest
     * @param News $news
     * @return void
     */
    public function addTagsToNews(FormRequest $formRequest, News $news): void
    {
        $tagServices = new TagServices();
        $tagsIds = $tagServices->getTagIdsForAttach($formRequest);
        $news->tags()->sync($tagsIds);
    }

    /**
     * Обновляет посты у поста
     *
     * @param FormRequest $formRequest
     * @param News $news
     * @return void
     */
    public function updateTagsToNews(FormRequest $formRequest, News $news): void
    {
        $tagServices = new TagServices();
        $tagsIds = $tagServices->getTagIdsForUpdate($formRequest, $news);
        $news->tags()->sync($tagsIds);
    }
}
