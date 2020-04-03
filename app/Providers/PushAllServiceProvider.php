<?php

namespace App\Providers;

use App\Services\ExternalServices\Pushall;
use Illuminate\Support\ServiceProvider;

class PushAllServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Pushall', function () {
            return new Pushall(config('externalServices.pushall.apiKey'), config('externalServices.pushall.id'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
