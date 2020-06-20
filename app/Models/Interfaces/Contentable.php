<?php

namespace App\Models\Interfaces;

interface Contentable
{
    /**
     * Возвращвает "красивое" имя модели для записи в отчеты
     *
     * @return string
     */
    public static function getLabelClass() : string ;
}
