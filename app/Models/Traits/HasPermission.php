<?php

namespace App\Models\Traits;

trait HasPermission
{
	/**
	 * This has any permissions to.
	 */
	public function hasAnyPermissionsTo($lists, $matchAll = false)
	{
		$result = [];

		foreach ($lists as $list) {
			$result[] = $this->rolesWithPermissions->pluck('permissions')->flatten()->contains('key', $list);
		}

		return $matchAll ? count($lists) == count(array_filter($result)) : count(array_filter($result));
	}
}
