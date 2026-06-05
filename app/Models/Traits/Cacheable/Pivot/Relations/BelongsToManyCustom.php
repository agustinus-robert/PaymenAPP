<?php namespace App\Models\Traits\Cacheable\Pivot\Relations;

use App\Models\Traits\Cacheable\Pivot\Traits\FiresPivotEventsTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BelongsToManyCustom extends BelongsToMany
{
    use FiresPivotEventsTrait;
}
