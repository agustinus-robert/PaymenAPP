<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable\Searchable;

class UserRole extends Model
{
    use Searchable;

    /**
     * Define the table associated with the model.
     *
     * @var string
     */
    protected $table = 'cmp_role_users';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'role_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // 'deleted_at' => 'datetime',
        // 'created_at' => 'datetime',
        // 'updated_at' => 'datetime',
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that are searchable.
     */
    public $searchable = [];

    /**
     * This belongs to user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
