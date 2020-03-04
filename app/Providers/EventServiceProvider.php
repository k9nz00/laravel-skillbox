<?php

namespace App\Providers;

use App\Events\PostEvents\CreatePostEvent;
use App\Events\PostEvents\DeletePostEvent;
use App\Events\PostEvents\UpdatePostEvent;
use App\Listeners\ChangePostStateListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreatePostEvent::class =>[
            ChangePostStateListener::class,
        ],
        UpdatePostEvent::class =>[
            ChangePostStateListener::class,
        ],
        DeletePostEvent::class =>[
            ChangePostStateListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
