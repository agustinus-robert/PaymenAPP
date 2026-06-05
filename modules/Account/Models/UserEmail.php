<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Modules\Account\Models\Repositories\UserEmailRepository;

class UserEmail extends Model
{
    use SoftDeletes, UserEmailRepository;

    /**
     * The table associated with the model.
     */
    protected $table = 'user_emails';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'address', 'verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'verified_at', 'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [];

    /**
     * This belongs to user.
     */
    public function user () {
        return $this->belongsTo(User::class);
    }

    /**
     * This verify email.
     */
    public function verify () {
        $this->update([
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        return $this;
    }

    /**
     * This unverify email.
     */
    public function unverify () {
        $this->update([
            'verified_at' => null
        ]);

        return $this;
    }
}
