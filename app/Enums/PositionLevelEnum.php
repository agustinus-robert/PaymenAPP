<?php

namespace App\Enums;

enum PositionLevelEnum: int
{
    case SHAREHOLDERS = 1;
    case COMMISSIONER = 2;
    case DIRECTOR = 3;
    case MANAGER = 4;
    case COORDINATOR = 5;
    case PROJECTMANAGER = 6;
    case STAFF = 7;
    case NONSTAFF = 8;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::SHAREHOLDERS => 'Pemegang Saham',
            self::COMMISSIONER => 'Komisaris',
            self::DIRECTOR => 'Direktur',
            self::MANAGER => 'Manajer',
            self::COORDINATOR => 'Koordinator',
            self::PROJECTMANAGER => 'Manajer Proyek',
            self::STAFF => 'Staf Fungsional',
            self::NONSTAFF => 'Non-staff',
        };
    }

    /**
     * Get the price
     */
    public function tmkadd(): int
    {
        return match ($this) {
            self::SHAREHOLDERS => 0,
            self::COMMISSIONER => 0,
            self::DIRECTOR => 40000,
            self::MANAGER => 35000,
            self::COORDINATOR => 30000,
            self::PROJECTMANAGER => 25000,
            self::STAFF => 20000,
            self::NONSTAFF => 0,
        };
    }

    /**
     * Get the price
     */
    public function decission(): bool
    {
        return match ($this) {
            self::SHAREHOLDERS, self::COMMISSIONER, self::MANAGER, self::COORDINATOR, self::PROJECTMANAGER, self::STAFF, self::NONSTAFF => false,
            self::DIRECTOR => true,
        };
    }

    /**
     * Get the price
     */
    public function releaseResult(): bool
    {
        return match ($this) {
            self::SHAREHOLDERS, self::COMMISSIONER, self::COORDINATOR, self::PROJECTMANAGER, self::STAFF, self::NONSTAFF => false,
            self::MANAGER, self::DIRECTOR => true,
        };
    }

    /**
     * Get the price
     */
    public function previewWithDecission(): bool
    {
        return match ($this) {
            self::SHAREHOLDERS, self::COMMISSIONER, self::COORDINATOR, self::PROJECTMANAGER, self::STAFF, self::NONSTAFF => false,
            self::MANAGER, self::DIRECTOR => true,
        };
    }
}
