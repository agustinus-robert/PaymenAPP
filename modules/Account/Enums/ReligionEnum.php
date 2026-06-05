<?php

namespace Modules\Account\Enums;

enum ReligionEnum: int
{
    case ISLAM = 1;
    case KRISTEN = 2;
    case KATHOLIK = 3;
    case HINDU = 4;
    case BUDHA = 5;
    case KONGHUCU = 6;


    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::ISLAM => 'Islam',
            self::KRISTEN => 'Kristen',
            self::KATHOLIK => 'Katholik',
            self::HINDU => 'Hindu',
            self::BUDHA => 'Budha',
            self::KONGHUCU => 'Konghucu',
        };
    }
}
