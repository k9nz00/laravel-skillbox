<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class PaginationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //дефолтный вид для обычной пагинации
        Paginator::defaultView('pagination::default');

        //дефолтный вид для простой пагинации
        Paginator::defaultSimpleView('pagination::simple-default');
    }
}
