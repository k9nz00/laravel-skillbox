<?php

namespace App\Http\Controllers\Admin\Report\Reports;

use App\Events\UpdatePost;
use App\Helpers\MessageHelpers;
use App\Http\Controllers\Controller;
use App\Jobs\Reports\TotalJob;
use App\Models\Comment;
use App\Models\News;
use App\Models\Post;
use App\Models\Tag;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Lang;

class TotalReportController extends Controller
{
    public function index()
    {
        $instances = require resource_path('lang/ru/reportsClassName.php');
        return view('admin.report.reports.total', compact('instances'));
    }

    public function generateReport(Request $request)
    {
        $instances = $request->input('instances');
        TotalJob::dispatch($instances, Auth::user()->email);

        $messageAboutCreate = 'Ваш отчет был добавлен в очередь генерации отчетов. Когда он будет сгененрирован будет произведена отправка на e-mail';
        MessageHelpers::flashMessage($messageAboutCreate);
        return back();
    }
}
