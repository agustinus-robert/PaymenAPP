<?php

namespace App\Enums;

enum ContractTypeEnum: int
{
    case PKWT = 1;
    case PKWTT = 2;
    case MAGANG = 3;
    case PROBATION = 4;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::PKWT => 'Pegawai kontrak',
            self::PKWTT => 'Pegawai tetap',
            self::MAGANG => 'Magang',
            self::PROBATION => 'Probation',
        };
    }
}
