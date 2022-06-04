<?php

namespace App\Helpers;

enum AgeRangeEnum
{
    private const MIN = 'min';
    private const MAX = 'max';
    private const RANGE = 'range';
    private const DEFAULT = 'range não encontrado';

    private const RANGE_1 = [
        self::MIN => 0,
        self::MAX => 4,
        self::RANGE => 'de 0 a 4 anos',
    ];
    private const RANGE_2 = [
        self::MIN => 5,
        self::MAX => 9,
        self::RANGE => 'de 5 a 9 anos',
    ];
    private const RANGE_3 = [
        self::MIN => 10,
        self::MAX => 14,
        self::RANGE => 'de 10 a 14 anos',
    ];
    private const RANGE_4 = [
        self::MIN => 15,
        self::MAX => 19,
        self::RANGE => 'de 15 a 19 anos',
    ];
    private const RANGE_5 = [
        self::MIN => 20,
        self::MAX => 24,
        self::RANGE => 'de 20 a 24 anos',
    ];
    private const RANGE_6 = [
        self::MIN => 25,
        self::MAX => 29,
        self::RANGE => 'de 25 a 29 anos',
    ];
    private const RANGE_7 = [
        self::MIN => 30,
        self::MAX => 34,
        self::RANGE => 'de 30 a 34 anos',
    ];
    private const RANGE_8 = [
        self::MIN => 35,
        self::MAX => 39,
        self::RANGE => 'de 35 a 39 anos',
    ];
    private const RANGE_9 = [
        self::MIN => 40,
        self::MAX => 44,
        self::RANGE => 'de 40 a 44 anos',
    ];
    private const RANGE_10 = [
        self::MIN => 45,
        self::MAX => 49,
        self::RANGE => 'de 45 a 49 anos',
    ];
    private const RANGE_11 = [
        self::MIN => 50,
        self::MAX => 54,
        self::RANGE => 'de 50 a 54 anos',
    ];
    private const RANGE_12 = [
        self::MIN => 55,
        self::MAX => 59,
        self::RANGE => 'de 55 a 59 anos',
    ];
    private const RANGE_13 = [
        self::MIN => 60,
        self::MAX => 64,
        self::RANGE => 'de 60 a 64 anos',
    ];
    private const RANGE_14 = [
        self::MIN => 65,
        self::MAX => 69,
        self::RANGE => 'de 65 a 69 anos',
    ];
    private const RANGE_15 = [
        self::MIN => 70,
        self::MAX => 74,
        self::RANGE => 'de 70 a 74 anos',
    ];
    private const RANGE_16 = [
        self::MIN => 75,
        self::MAX => 79,
        self::RANGE => 'de 75 a 79 anos',
    ];
    private const RANGE_17 = [
        self::MIN => 80,
        self::MAX => 84,
        self::RANGE => 'de 80 a 84 anos',
    ];
    private const RANGE_18 = [
        self::MIN => 85,
        self::MAX => 89,
        self::RANGE => 'de 85 a 89 anos',
    ];
    private const RANGE_19 = [
        self::MIN => 90,
        self::MAX => 94,
        self::RANGE => 'de 90 a 94 anos',
    ];
    private const RANGE_20 = [
        self::MIN => 95,
        self::MAX => 99,
        self::RANGE => 'de 95 a 99 anos',
    ];
    private const RANGE_21 = [
        self::MIN => 100,
        self::MAX => INF,
        self::RANGE => 'mais de 100 anos',
    ];

    private const AGES_RANGES = [
        'range0To4' => self::RANGE_1,
        'range5To9' => self::RANGE_2,
        'range10To14' => self::RANGE_3,
        'range15To19' => self::RANGE_4,
        'range20To24' => self::RANGE_5,
        'range25To29' => self::RANGE_6,
        'range30To34' => self::RANGE_7,
        'range35To39' => self::RANGE_8,
        'range40To44' => self::RANGE_9,
        'range45To49' => self::RANGE_10,
        'range50To54' => self::RANGE_11,
        'range55To59' => self::RANGE_12,
        'range60To64' => self::RANGE_13,
        'range65To69' => self::RANGE_14,
        'range70To74' => self::RANGE_15,
        'range75To79' => self::RANGE_16,
        'range80To84' => self::RANGE_17,
        'range85To89' => self::RANGE_18,
        'range90To94' => self::RANGE_19,
        'range95To99' => self::RANGE_20,
        'range100ToINF' => self::RANGE_21
    ];

    case range0To4;
    case range5To9;
    case range10To14;
    case range15To19;
    case range20To24;
    case range25To29;
    case range30To34;
    case range35To39;
    case range40To44;
    case range45To49;
    case range50To54;
    case range55To59;
    case range60To64;
    case range65To69;
    case range70To74;
    case range75To79;
    case range80To84;
    case range85To89;
    case range90To94;
    case range95To99;
    case range100ToINF;

    public static function getRange(int $value): string
    {
        foreach (self::AGES_RANGES as $range) {
            if ($range[self::MIN] <= $value  && $value <= $range[self::MAX]) {
                return $range[self::RANGE];
            }
        }

        return self::DEFAULT;
    }

    public function getRangeValues(): array
    {
        return self::AGES_RANGES[$this->name];
    }
}