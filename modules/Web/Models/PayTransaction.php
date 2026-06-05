<?php

namespace Modules\Web\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable\Searchable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Account\Models\UserLogBalance;
use Modules\Account\Models\User;

class PayTransaction extends Model
{
    protected $table = 'pay_transactions';

    protected $fillable = [
        'transaction_code',
        'sender_id',
        'receiver_id',
        'amount',
        'status',
        'description',
    ];
    /**
     * Define the table associated with the model.
     *
     * @var string
     */

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(UserLogBalance::class, 'modelable');
    }
}
