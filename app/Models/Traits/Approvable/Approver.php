<?php

namespace App\Models\Traits\Approvable;

use App\Models\Approvable;

trait Approver
{
    /**
     * Get all of the approver.
     */
    public function approver()
    {
        return $this->morphMany(Approvable::class, 'userable');
    }

    /**
     * Get approver label.
     */
    public function getApproverLabel()
    {
        return data_get($this, 'position.name');
    }

    /**
     * Get user instance.
     */
    public function getUser()
    {
        return data_get($this, 'user');
    }
}
