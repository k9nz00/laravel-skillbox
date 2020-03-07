<?php

namespace App\Providers;

use App\Models\Tag;
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
          $view->with('tagsCloud', Tag::getTagsCloud());
        });
    }
}
