<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $table = 'sessions';
    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(\Modules\Account\Models\User::class, 'user_id');
    }
}
