<?php

namespace App\Jobs\Reports;

use App\Mail\Reports\TotalReport;
use App\Models\Interfaces\Contentable;
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
     * @throws \Exception
     */
    public function handle()
    {
        $report = $this->generateReport($this->getCountInstances($this->instances));
        Mail::to($this->toUserMail)
            ->send(new TotalReport($this->getCountInstances($this->instances), $report));
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
            $instancesCount[] = [
                $instance::getLabelClass(),
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
        array_unshift($data, ['Наименование', 'Количество']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);

        $writer = new Xlsx($spreadsheet);
        $pathToReport = 'reports/totalReports/report' . date('_Y_m_d_H_i') . '.xlsx';
        $writer->save(storage_path($pathToReport));

        return $this->getPathToReport($pathToReport);
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
        if (file_exists(storage_path($pathToReport))) {
            return storage_path($pathToReport);
        } else {
            throw new \Exception('Файла по адресу ' . $pathToReport . ' не существует');
        }
    }
}
