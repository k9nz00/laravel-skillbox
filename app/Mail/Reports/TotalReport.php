<?php

namespace App\Mail\Reports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TotalReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array двумерный массив именем класс и количество элементов на сайте
     */
    public $instances;

    /**
     * Путь к файлу с отчетом
     *
     * @var string
     */
    public $pathToFileReport;

    /**
     * Create a new message instance.
     *
     * @param array $instances
     * @param string $pathToFileReport
     */
    public function __construct(array $instances, string $pathToFileReport)
    {
        $this->instances = $instances;
        $this->pathToFileReport = $pathToFileReport;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('mail.reports.totalReport')
            ->attach($this->pathToFileReport);
    }
}
