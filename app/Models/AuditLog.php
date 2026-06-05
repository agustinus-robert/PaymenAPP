<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Account\Models\User;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'auditable_id',
        'auditable_type',
        'event',
        'description',
        'old_values',
        'new_values',
        'user_id',
        'url',
        'ip_address',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function auditable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
