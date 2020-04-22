<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Замена пробелов на неразрывные
     *
     * @param string $txt
     * @param int $limit не заменять при длине строки больше $limit, 0 - без ограничений
     * @return string
     */
    public static function nobr($txt, $limit = 0)
    {
        return ((!$limit) || strlen($txt) < $limit) ? preg_replace('/\s+/', '&nbsp;', $txt) : $txt;
    }

    /**
     * Обрезает текст до нужной длины и подставляет в конце если нужно какие то символы, например '...'
     * Если обрезанный текст с добавленным вконце $ending будет длиннее чем исходный текст, то обрезание не производится.
     *
     * @param string $text
     * @param int $length
     * @param string $ending
     * @return string
     */
    public static function crop($text, $length, $ending = '...')
    {
        return (strlen($text) < $length + strlen($ending)) ? $text : mb_substr($text, 0, $length, 'UTF-8') . $ending;
    }

    /**
     * Обрезает символы пробелов и переносов строк по краям текста с учетом UTF-8
     * Также убивает служебные символы
     *
     * @param string $text
     * @return string
     */
    public static function trim($text)
    {
        return preg_replace('/^\s*(\S[\s\S]*\S)\s*$/m', '\\1', preg_replace('/(\p{Cf})/mu', '', $text));
    }

    /**
     * Возвращает длину строки с учетом UTF-8
     *
     * @param string $text
     * @return int
     */
    public static function strlen($text)
    {
        return mb_strlen($text, 'UTF-8');
    }

    /**
     * Переводит текст в нижний регистр с учетом UTF-8
     *
     * @param string $text
     * @return string
     */
    public static function lower($text)
    {
        return mb_strtolower($text, 'UTF-8');
    }

    /**
     * Переводит текст в верхний регистр с учетом UTF-8
     *
     * @param string $text
     * @return string
     */
    public static function upper($text)
    {
        return mb_strtoupper($text, 'UTF-8');
    }

    /**
     * Аналог ucfirst с учетом UTF-8.
     *
     * Поднимает первую букву в верхний регистр
     *
     * @param string $text
     * @return string
     */
    public static function ucfirst($text)
    {
        return (string)mb_strtoupper(mb_substr($text, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($text, 1, mb_strlen($text),
                'UTF-8');
    }

    /**
     * Аналог lcfirst с учетом UTF-8.
     *
     * Переводит первую букву в нижний регистр
     *
     * @param string $text
     * @return string
     */
    public static function lcfirst($text)
    {
        return (string)mb_strtolower(mb_substr($text, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($text, 1, mb_strlen($text),
                'UTF-8');
    }

    /**
     * Текстовое представление денег
     *
     * @param double $money
     * @return string
     */
    public static function moneyWord($money)
    {
        $nul = 'ноль';
        $ten = [
            ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
            ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ];
        $a20 = [
            'десять',
            'одиннадцать',
            'двенадцать',
            'тринадцать',
            'четырнадцать',
            'пятнадцать',
            'шестнадцать',
            'семнадцать',
            'восемнадцать',
            'девятнадцать',
        ];
        $tens = [
            2 => 'двадцать',
            'тридцать',
            'сорок',
            'пятьдесят',
            'шестьдесят',
            'семьдесят',
            'восемьдесят',
            'девяносто',
        ];
        $hundred = [
            '',
            'сто',
            'двести',
            'триста',
            'четыреста',
            'пятьсот',
            'шестьсот',
            'семьсот',
            'восемьсот',
            'девятьсот',
        ];
        $unit = [
            ['копейка', 'копейки', 'копеек', 1],
            ['рубль', 'рубля', 'рублей', 0],
            ['тысяча', 'тысячи', 'тысяч', 1],
            ['миллион', 'миллиона', 'миллионов', 0],
            ['миллиард', 'милиарда', 'миллиардов', 0],
        ];
        //
        [$rub, $kop] = explode('.', sprintf('%015.2f', floatval($money)));
        $out = [];
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) {
                    continue;
                }
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                [$i1, $i2, $i3] = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1) {
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                } else {
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                }
                // units without rub & kop
                if ($uk > 1) {
                    $out[] = self::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
                }
            } //foreach
        } else {
            $out[] = $nul;
        }
        $out[] = self::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . self::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));
    }

    /**
     * Склоняем словоформу по последней цифре числа $n
     *
     * Например
     * (1, 'ребенок', 'ребенка', 'детей') == ребенок
     * (2, 'ребенок', 'ребенка', 'детей') == ребенка
     * (5, 'ребенок', 'ребенка', 'детей') == детей
     *
     * @param int $n
     * @param string $f1
     * @param string $f2
     * @param string $f5
     * @return string
     */
    public static function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) {
            return $f5;
        }
        $n = $n % 10;
        if ($n > 1 && $n < 5) {
            return $f2;
        }
        if ($n == 1) {
            return $f1;
        }
        return $f5;
    }


    /**
     * Возвращает безопасную строку
     *
     * @param string $text
     * @param bool $autoTrim
     * @return string
     */
    public static function safeText($text, $autoTrim = true)
    {
        return $text ? htmlspecialchars(strip_tags($autoTrim ? self::trim($text) : $text)) : '';
    }

    /**
     * Генерит случайный код заданной длины, например "vykiS7aOm"
     *
     * @param int $lenght
     * @param bool $moreChars
     * @return string
     */
    public static function makeRandomLetterCode($lenght = 6, $moreChars = false)
    {
        $letters = !$moreChars ? 'abcdefABCDEF1234567890' : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        return substr(str_shuffle(str_shuffle($letters)), 0, $lenght);
    }
}
