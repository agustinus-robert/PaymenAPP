<?php

namespace Modules\Account\Models\Traits;

trait RoleTrait
{	
	/**
     * Find by email.
     */
	public function scopeSearch($query, $search)
	{
		return $query->when($search, function($subquery, $search) {
            $subquery->where('name', 'like', '%'.$search.'%')->orWhere('display_name', 'like', '%'.$search.'%');
        });
	}

	/**
     * Has permissions.
     */
	public function hasPermissions(array $permissions, $all = false)
	{
		return $all 
			? collect($permissions)->diff($this->permissions->pluck('name'))->count() <= 0
			: $this->permissions->pluck('name')->intersect($permissions)->count() > 0;
	}
}