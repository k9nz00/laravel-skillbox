<?php

namespace App\Jobs\Reports;

use App\Events\TotalReportTextEvent;
use App\Mail\Reports\TotalReport;
use App\Models\Interfaces\Contentable;
use App\Services\ReportServices\ReportInstances;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Storage;

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
     * @var ReportInstances
     */
    protected $reportInstances;

    /**
     * @var string получатель письма
     */
    protected $toUserMail;

    /**
     * Create a new job instance.
     *
     * @param ReportInstances $reportInstances
     * @param string $toUserMail
     */
    public function __construct(ReportInstances $reportInstances, string $toUserMail)
    {
        $this->reportInstances = $reportInstances;
        $this->toUserMail = $toUserMail;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $report = $this->generateReport($this->getCountInstances());
        event(new TotalReportTextEvent($this->addTitleToReport($this->getCountInstances())));
        Mail::to($this->toUserMail)
            ->send(new TotalReport($this->getCountInstances(), $report));
    }

    /**
     * Получить количество сущностей в системе
     *
     * @param array $instances
     * @return array
     */
    public function getCountInstances(): array
    {
        $instancesCount = [];
        foreach ($this->reportInstances->instances as $instance) {
            $instancesCount[] = [
                __('reportsClassName.' . $instance),
                $instance::count(),
            ];
        }
        return $instancesCount;
    }

    /**
     * Создает файл .xls  для отчет и возвращает путь к нему
     *
     * @param array $data
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \Exception
     */
    public function generateReport(array $data): string
    {
        $data = $this->addTitleToReport($data);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);

        $writer = new Xlsx($spreadsheet);
        $pathToReport = 'reports/totalReports/report' . date('_Y_m_d_H:i') . '.xlsx';
        $writer->save(storage_path($pathToReport));

        return $this->getPathToReport($pathToReport);
    }

    /**
     * @param array $data
     * @return array
     */
    public function addTitleToReport(array $data)
    {
        array_unshift($data, ['Наименование', 'Количество']);
        return $data;
    }

    /**
     * Проверяет существование файла по указанному пути
     * В случае успеха возвращает путь к нему
     *
     * @param $pathToReport
     * @return string
     * @throws \Exception
     */
    public function getPathToReport($pathToReport): string
    {
        if (Storage::disk('root')->exists($pathToReport)) {
            return storage_path($pathToReport);
        } else {
            throw new \Exception('Файла по адресу ' . $pathToReport . ' не существует');
        }
    }
}
