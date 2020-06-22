<?php

namespace App\Http\Controllers\Admin\Report\Reports;

use App\Helpers\MessageHelpers;
use App\Http\Controllers\Controller;
use App\Jobs\Reports\TotalJob;
use App\Services\ReportServices\ReportInstances;
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
        $reportInstances = new ReportInstances($request->input('instances'));

        if (!empty($reportInstances->instances)) {
            TotalJob::dispatch($reportInstances, Auth::user()->email);
            $messageAboutCreate = 'Ваш отчет был добавлен в очередь генерации отчетов. Когда он будет сгененрирован будет произведена отправка на e-mail';
            MessageHelpers::flashMessage($messageAboutCreate);
        }
        return back();
    }
}
