<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Web\Models\PayTransaction;

class UserLogBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'modelable_id',
        'modelable_type',
        'adjustment_status',
        'log_user',
    ];

    protected $casts = [
        'adjustment_status' => 'integer',
    ];

    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }
}
