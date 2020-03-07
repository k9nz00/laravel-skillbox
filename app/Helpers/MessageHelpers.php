<?php

namespace App\Helpers;

class MessageHelpers
{
    public static function flashMessage(string $message, string $typeMessage = 'success') : void
    {
        session()->flash('messageAboutPostStatus', $message);
        session()->flash('typeMessage', $typeMessage);
    }

}