<?php

namespace App\Http\Controllers\Admin\Report\Reports;

use App\Http\Controllers\Controller;
use App\Jobs\Reports\TotalJob;
use App\Models\Comment;
use App\Models\News;
use App\Models\Post;
use App\Models\Tag;
use App\User;
use Auth;
use Illuminate\Http\Request;

class TotalReportController extends Controller
{
    public function index()
    {
        $instances = [
            News::class => 'Новости',
            Post::class => 'Статьи',
            Comment::class => 'Комментарии',
            Tag::class => 'Теги',
            User::class => 'Пользователи'
        ];

        return view('admin.report.reports.total', compact('instances'));
    }

    public function generateReport(Request $request)
    {
        $instances = $request->input('instances');
        TotalJob::dispatch($instances, Auth::user()->email);
        return back();
    }
}
