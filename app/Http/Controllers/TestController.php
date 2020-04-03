<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $date = Carbon::now();
        $date1 = Carbon::now()->subWeek();

        var_dump($date);
        var_dump($date1);


    }
}
