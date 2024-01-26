<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Month extends Enum
{
    const January = 1;
    const February = 2;
    const March = 3;
    const April = 4;
    const May = 5;
    const June = 6;
    const July = 7;
    const August = 8;
    const September = 9;
    const October = 10;
    const November = 11;
    const December = 12;

    public static function getMonthLabels(): array
    {
        return [
            self::January => '1月',
            self::February => '2月',
            self::March => '3月',
            self::April => '4月',
            self::May => '5月',
            self::June => '6月',
            self::July => '7月',
            self::August => '8月',
            self::September => '9月',
            self::October => '10月',
            self::November => '11月',
            self::December => '12月',
        ];
    }
}