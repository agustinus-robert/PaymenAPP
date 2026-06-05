<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;

use Modules\Account\Models\Traits\RoleTrait;

class Role extends Model
{
    use RoleTrait;

    /**
     * The table associated with the model.
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'module', 'display_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This has many users.
     */
    public function users () {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }

    /**
     * This has many permissions.
     */
    public function permissions () {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }
}
