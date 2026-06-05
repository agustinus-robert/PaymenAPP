<?php namespace App\Models\Traits\Cacheable;

use App\Models\Traits\Cacheable\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

abstract class CachedModel extends Model
{
    use Cachable;
}
