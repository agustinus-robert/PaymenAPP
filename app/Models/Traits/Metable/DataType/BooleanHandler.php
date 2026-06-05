<?php

namespace App\Models\Traits\Metable\DataType;

/**
 * Handle serialization of booleans.
 */
class BooleanHandler extends ScalarHandler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'boolean';
}
