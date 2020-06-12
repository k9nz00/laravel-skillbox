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
     * @var array Массив, где ключ имя класса-сущности, а значение сколько записей такой сущности в БД имеется
     */
    public $instances;

    /**
     * Create a new message instance.
     *
     * @param array $instances
     */
    public function __construct(array $instances)
    {
        $this->instances = $instances;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.reports.totalReport');
    }
}
