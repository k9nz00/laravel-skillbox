<?php

namespace App\Http\Controllers\Admin\Report\Reports;

use App\Helpers\MessageHelpers;
use App\Http\Controllers\Controller;
use App\Jobs\Reports\TotalJob;
use Auth;
use Illuminate\Http\Request;
use Lang;

class TotalReportController extends Controller
{
    public function index()
    {
        $instances = Lang::get('reportsClassName');
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
