<?php

namespace App\Enums;

enum PayrollSettingEnum: int
{
    case APPROVABLE = 1;
    case API = 2;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::APPROVABLE => 'Persetujuan',
            self::API => 'API Endpoint'
        };
    }

    /**
     * Get the label accessor with label() object
     */
    public function template(): string
    {
        return match ($this) {
            self::APPROVABLE => 'admin::config.approval',
            self::API => 'admin::config.api'
        };
    }
}
