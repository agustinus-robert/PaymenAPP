<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Account\Models\UserLogBalance;
use App\Models\User;

class UserBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_balance_id',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_balance_id');
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(UserLogBalance::class, 'modelable');
    }
}
