<?php

namespace App\Models\Traits\Cacheable;

use Illuminate\Database\Eloquent\Builder;

class ModelCaching
{
    protected static $builder = Builder::class;

    public static function useEloquentBuilder(string $builder) : void
    {
        self::$builder = $builder;
    }

    public static function builder()
    {
        return self::$builder;
    }
}
