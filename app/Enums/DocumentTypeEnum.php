<?php

namespace App\Enums;

enum DocumentTypeEnum: int
{
    case SYSTEM = 1;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::SYSTEM => 'Dokumen sistem',
        };
    }
}
