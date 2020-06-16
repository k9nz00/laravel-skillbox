<?php

namespace App\Jobs\Reports;

use App\Mail\Reports\TotalReport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 *
 * Class TotalJob этот класс формирует отчет, котором подсчитывает количество сущностей на сайте,
 * указанных к поле classes
 * Сформированный отсчет отправляется на почту.
 * В письме в виде текста выводятся даннные отчета, а также в виду .xls и .pdf  файлов
 * @package App\Jobs\Reports
 */
class TotalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Массив с классами для которых необходимо сформировать отчет
     *
     * @var array
     */
    protected $instances;

    /**
     * @var string получатель письма
     */
    protected $toUserMail;

    /**
     * Create a new job instance.
     *
     * @param array $instances
     * @param string $toUserMail
     */
    public function __construct(array $instances, string $toUserMail)
    {
        $this->instances = $instances;
        $this->toUserMail = $toUserMail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->generateReportToXLS();

        Mail::to($this->toUserMail)
            ->send(new TotalReport($this->getCountInstances($this->instances)));
    }

    /**
     * Получить количество сущностей в системе
     *
     * @param array $instances
     * @return array
     */
    public function getCountInstances(array $instances): array
    {
        $instancesCount = [];
        foreach ($instances as $instance) {
            $instancesCount[$instance] = $instance::count();
        }
        return $instancesCount;
    }

    public function generateReportToXLS()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save( storage_path('reports/totalReports/hello_world.xlsx'));

    }
}
