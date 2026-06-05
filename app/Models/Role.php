<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Permission;
use App\Models\Traits\Cacheable\Cacheable;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;
use Modules\Account\Models\User;

class Role extends Model
{
    use Cacheable, Searchable, Restorable;

    /**
     * The table associated with the model.
     */
    protected $table = 'app_roles';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'kd', 'name'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [
        'kd', 'name'
    ];

    /**
     * This belongs to many permissions.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'app_role_permissions', 'role_id', 'permission_id');
    }

    /**
     * This belongs to many users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }

    /**
     * This has any permissions to.
     */
    public function hasAnyPermissionsTo($lists, $matchAll = false)
    {
        $result = [];

        foreach ((array) $lists as $list) {
            $result[] = $this->permissions->contains('key', $list);
        }

        return $matchAll ? count($lists) == count(array_filter($result)) : count(array_filter($result));
    }
}
