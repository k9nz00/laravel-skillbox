<?php

namespace App\Providers;

use App\Models\Interfaces\Contentable;
use App\Models\News;
use App\Models\Post;
use App\Models\Tag;
use Cache;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.layoutsChunk.aside', function (View $view) {
            $usedTags = Cache::tags([Contentable::CONTENT, Post::CACHE_TAGS, News::CACHE_KEY])
                ->remember('usedTags', 3600, function () {
                    return Tag::getTagsCloud();
                });
            $view->with('tagsCloud', $usedTags);
        });
    }
}
