<?php namespace App\Models\Traits\Cacheable;

use App\Models\Traits\Cacheable\Pivot\Traits\FiresPivotEventsTrait;
use App\Models\Traits\Cacheable\Traits\Buildable;
use App\Models\Traits\Cacheable\Traits\BuilderCaching;
use App\Models\Traits\Cacheable\Traits\Caching;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CachedBelongsToMany extends BelongsToMany
{
    use Buildable;
    use BuilderCaching;
    use Caching;
    use FiresPivotEventsTrait;
}
