<?php

namespace Modules\Account\Enums;

enum MariageEnum: int
{
    case MARRY   = 1;
    case SINGLE  = 2;
    case WIDDOW  = 3;
    case WIDOWER = 4;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::MARRY   => 'Menikah',
            self::SINGLE  => 'Belum menikah',
            self::WIDDOW  => 'Janda',
            self::WIDOWER => 'Duda',
        };
    }
}
