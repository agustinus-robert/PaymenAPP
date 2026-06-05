<?php

namespace Modules\Account\Models\Repositories;

trait UserRepository
{
	/**
     * Update password.
     */
	public function updatePassword($password)
	{
		$this->update([
			'password' => bcrypt($password)
		]);

		return $this;
	}

	/**
     * Reset password.
     */
	public function resetPassword($length = 2)
	{
		$password = self::generatePassword($length);
		$this->updatePassword($password);

		return $password;
	}
}