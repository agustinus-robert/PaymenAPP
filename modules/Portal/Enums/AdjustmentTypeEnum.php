<?php

namespace Modules\Portal\Enums;

enum StatusTransactionEnum :string
{
    case ADD = 1;
    case MINUS = 2;

    public function label(): string
    {
        return match ($this) {
            self::ADD   => 'Penambahan Saldo',
            self::MINUS  => 'Penarikan Saldo',
        };
    }
}
