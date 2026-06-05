<?php

namespace App\Models\Traits\Restorable;

use Illuminate\Database\Eloquent\SoftDeletes;

trait Restorable
{
	use SoftDeletes;

    /**
     * When trashed.
     */
    public function scopeWhenTrashed ($query, $trashed) {
        return $query->when($trashed, fn ($subquery) => $subquery->onlyTrashed());
    }

    /**
     * When with trashed.
     */
    public function scopeWhenWithTrashed ($query, $trashed) {
        return $query->when($trashed, fn ($subquery) => $subquery->withTrashed());
    }

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->where($this->getRouteKeyName(), $value)->first();
    }
}