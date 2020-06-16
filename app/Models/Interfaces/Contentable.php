<?php

namespace App\Models\Interfaces;

interface Contentable
{
    public function getClass();

    /**
     * Возвращвает "красивое" имя модели для записи в отчеты
     *
     * @return string
     */
    public static function getLabelClass() : string ;
}
