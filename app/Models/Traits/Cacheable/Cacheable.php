<?php

namespace App\Models\Traits\Cacheable;

use App\Models\Traits\Cacheable\Traits;
use App\Models\Traits\Cacheable\Pivot\Traits\PivotEventTrait;

trait Cacheable 
{
    use Traits\Caching;
    use Traits\ModelCaching;
    use PivotEventTrait {
        Traits\ModelCaching::newBelongsToMany insteadof PivotEventTrait;
    }
}
