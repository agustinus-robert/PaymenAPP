<?php

namespace App\Models\Traits\Metable\DataType;

/**
 * Handle serialization of strings.
 */
class StringHandler extends ScalarHandler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'string';
}
