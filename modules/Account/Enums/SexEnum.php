<?php

namespace Modules\Account\Enums;

enum SexEnum :int
{
    case MALE = 1;
    case FEMALE = 2;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match($this) 
        {
            self::MALE => 'Pria',
            self::FEMALE => 'Wanita'
        };
    }
}