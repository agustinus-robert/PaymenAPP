<?php namespace App\Models\Traits\Cacheable\Traits;

use App\Models\Traits\Cacheable\Pivot\Traits\PivotEventTrait;

trait Cachable
{
    use Caching;
    use ModelCaching;
    use PivotEventTrait {
        ModelCaching::newBelongsToMany insteadof PivotEventTrait;
    }
}
