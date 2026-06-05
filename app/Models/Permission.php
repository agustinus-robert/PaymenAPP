<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "app_permissions";

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key', 'name', 'description', 'module'
    ];
    
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;
}
