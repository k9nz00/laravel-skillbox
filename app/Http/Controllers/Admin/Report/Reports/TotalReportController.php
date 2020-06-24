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

    /**
     * @param Request $request
     * @return array
     */
    public function generateReport(Request $request)
    {
        $instances = $request->input('instances');
        $response = [];

        if ($instances) {
            $reportInstances = new ReportInstances($instances);
            TotalJob::dispatch($reportInstances, Auth::user()->email);
            $response['message'] = 'Ваш отчет был добавлен в очередь генерации отчетов. Когда он будет сгененрирован будет произведена отправка на e-mail';
            $response['style'] = 'alert-success';
        } else {
            $response['message'] = 'Не выбран ни один пункт для формирования отчета.';
            $response['style'] = 'alert-danger';
        }
        return $response;
    }
}
