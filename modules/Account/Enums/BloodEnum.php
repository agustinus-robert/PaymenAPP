<?php

namespace Modules\Account\Enums;

enum BloodEnum :string
{
    case A = 'A';
    case B = 'B';
    case AB = 'AB';
    case O = 'O';

    /**
     * Get the label accessor with label() object
     */
    public function label(): string
    {
        return $this->value;
    }
}