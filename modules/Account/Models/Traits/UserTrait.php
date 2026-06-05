<?php

namespace Modules\Account\Models\Traits;

trait UserTrait
{	
	/**
     * Find by name or username.
     */
	public function scopeSearch($query, $search)
	{
		return $query->when($search, function($q, $search) {
            $q->where(function ($subquery) use ($search) {
				$subquery->whereNameLike($search)->orWhere('username', 'like', '%'.$search.'%');
			});
        });
	}

	/**
     * Find by email.
     */
	public function scopeWhereEmail($query, $address)
	{
		return $query->whereHas('email', function ($email) use ($address) {
			$email->where('address', $address);
		});
	}

	/**
     * Find by name.
     */
	public function scopeWhereNameLike($query, $name)
	{
		return $query->whereHas('profile', function ($profile) use ($name) {
			$profile->where('name', 'like', '%'.$name.'%');
		});
	}
}