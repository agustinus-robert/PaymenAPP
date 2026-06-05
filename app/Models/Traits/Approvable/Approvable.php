<?php

namespace App\Models\Traits\Approvable;

use App\Models\Approvable as ApprovableModel;
use App\Enums\ApprovableResultEnum;

trait Approvable
{
    /**
     * Get all of the approvables.
     */
    public function approvables()
    {
        return $this->morphMany(ApprovableModel::class, 'modelable');
    }

    /**
     * Create approvable.
     */
    public function createApprovable($userable, $data = [])
    {
        if (isset($userable->id)) {
            $this->approvables()->create(array_merge([
                'userable_type' => get_class($userable),
                'userable_id' => $userable->id,
                'level' => $this->approvables()->count() + 1
            ], $data));
        }
    }

    /**
     * Check if model has approvable.
     */
    public function hasApprovables()
    {
        return $this->approvables->count() > 0;
    }

    /**
     * Check if aprovables type is approvable.
     */
    public function approvableTypeIs($type)
    {
        if ($this->hasApprovables()) {
            return match ($type) {
                'approvable' => $this->approvables->first()->cancelable == 0,
                'cancelable' => $this->approvables->first()->cancelable == 1,
                default => false
            };
        }
        return false;
    }

    /**
     * Check if approvable has any result in array, and return boolean.
     */
    public function hasAnyApprovableResultIn($values = [], $all = false, $cancelable = 0)
    {
        $count = $this->approvables->filter(
            fn ($a) => $a->cancelable == $cancelable && in_array($a->result, array_map(fn ($value) => ApprovableResultEnum::tryFromName($value), is_array($values) ? $values : [$values]))
        )->count();

        return $all ? $count == $this->approvables->count() : $count > 0;
    }

    /**
     * Check if approvable has all result in array
     */
    public function hasAllApprovableResultIn($values = [])
    {
        return $this->hasAnyApprovableResultIn($values, true);
    }

    /**
     * Check if cancelable has any result in array.
     */
    public function hasAnyCancelableResultIn($values = [], $all = false)
    {
        return $this->hasAnyApprovableResultIn($values, true, 1);
    }

    /**
     * Check if cancelable has all result in array
     */
    public function hasAllCancelableResultIn($values = [])
    {
        return $this->hasAnyApprovableResultIn($values, true, 1);
    }
}
