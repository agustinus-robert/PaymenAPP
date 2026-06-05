<?php namespace App\Models\Traits\Cacheable\Pivot\Relations;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\Traits\Cacheable\Pivot\Traits\FiresPivotEventsTrait;

class MorphToManyCustom extends MorphToMany
{
    use FiresPivotEventsTrait;
}
