<?php

namespace App\Enums;

enum ApprovableResultEnum: int
{
    case PENDING = 0;
    case APPROVE = 1;
    case REJECT = 2;
    case REVISION = 3;

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Menunggu',
            self::APPROVE => 'Disetujui',
            self::REJECT => 'Ditolak',
            self::REVISION => 'Perlu revisi'
        };
    }

    /**
     * Get the color accessor with color() object
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'dark',
            self::APPROVE => 'success',
            self::REJECT => 'danger',
            self::REVISION => 'warning'
        };
    }

    /**
     * Get the icon accessor with icon() object
     */
    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'mdi mdi-timer-outline',
            self::APPROVE => 'mdi mdi-check-circle-outline',
            self::REJECT => 'mdi mdi-close-circle-outline',
            self::REVISION => 'mdi mdi-alert-circle-outline'
        };
    }

    /**
     * Get required fields for reason
     */
    public function reasonRequirement(): bool
    {
        return match ($this) {
            self::PENDING, self::APPROVE => false,
            self::REJECT, self::REVISION => true
        };
    }

    /**
     * Try from name
     */
    public static function tryFromName(string $name): ?static
    {
        foreach (static::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}
