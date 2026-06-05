<?php

namespace Modules\Account\Models\Traits;

trait UserRBACTrait
{
	/**
     * Get all full permissions without plucked.
     */
	public function allFullPermissions()
	{
		return collect($this->roles->load('permissions')->pluck('permissions')->flatten())->merge($this->permissions);
	}

	/**
     * Get all permissions.
     */
	public function allPermissions()
	{
		return $this->allFullPermissions()->pluck('name')->unique();
	}

	/**
     * Get all roles.
     */
	public function allRoles()
	{
		return $this->roles->pluck('name');
	}

	/**
     * Is admin.
     */
	public function isAdmin($module = 'account')
	{
		return !!$this->allFullPermissions()->where('module', $module)->count();
	}

	/**
     * Has roles.
     */
	public function hasRoles(array $roles, $all = false)
	{
		return $all 
			? collect($roles)->diff($this->allRoles()->flatten())->count() <= 0
			: $this->allRoles()->intersect($roles)->count() > 0;
	}

	/**
     * Has permissions.
     */
	public function hasPermissions(array $permissions, $all = false)
	{
		return $all 
			? collect($permissions)->diff($this->allPermissions()->flatten())->count() <= 0
			: $this->allPermissions()->intersect($permissions)->count() > 0;
	}
}