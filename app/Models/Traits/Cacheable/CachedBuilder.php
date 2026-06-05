<?php namespace App\Models\Traits\Cacheable;

use App\Models\Traits\Cacheable\Traits\Buildable;
use App\Models\Traits\Cacheable\Traits\BuilderCaching;
use App\Models\Traits\Cacheable\Traits\Caching;

class CachedBuilder extends EloquentBuilder
{
    use Buildable;
    use BuilderCaching;
    use Caching;
}
