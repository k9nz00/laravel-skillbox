<?php

namespace App\Services\ReportServices;

class ReportInstances
{
    /**
     * Массив с именами моделей для отчета
     *
     * @var array
     */
    public $instances;

    /**
     * ReportInstances constructor.
     * @param array $instances
     */
    public function __construct(array $instances)
    {
        $this->instances = $instances;
    }
}
