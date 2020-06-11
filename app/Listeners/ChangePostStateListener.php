<?php

namespace App\Listeners;

use App\Events\PostEvents\AbstractPostEvent;
use App\Mail\Posts\ChangePostStateMail;
use Mail;

class ChangePostStateListener
{
    /**
     * Handle the event.
     *
     * @param AbstractPostEvent $event
     * @return void
     */
    public function handle(AbstractPostEvent $event)
    {
        Mail::to(config('mail.from.adminAddress'))->send(
            new ChangePostStateMail($event)
        );
    }
}
