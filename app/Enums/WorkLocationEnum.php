<?php

namespace App\Enums;

enum WorkLocationEnum: int
{
    case WFO = 1;
    case WFA = 2;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::WFO => 'Work from Office',
            self::WFA => 'Work from Anywhere'
        };
    }

    /**
     * Select enumerations with given case
     */
    public static function select($case)
    {
        return match ($case) {
            'WFO' => self::WFO,
            'WFA' => self::WFA,
            default => abort(404)
        };
    }
}
