<?php

namespace Modules\Account\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable\Searchable;

class UserLog extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'message', 'modelable_type', 'modelable_id', 'ip', 'user_agent'
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
    public $searchable = [
        'message'
    ];

    /**
     * Get device attributes.
     */
    public function getDeviceAttribute () {
        $str = $this->user_agent;

        $pos1 = strpos($str, '(')+1;
        $pos2 = strpos($str, ')')-$pos1;
        $part = substr($str, $pos1, $pos2);
        $parts = explode(" ", $part);

        return implode(' ', $parts);
    }

    /**
     * This belongs to user.
     */
    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * This modelable morph.
     */
    public function modelable () {
        return $this->morphTo();
    }

    /**
     * When user id.
     */
    public function scopeWhenUserId ($query, $id)
    {
        return $query->when($id, fn ($query, $id) => $query->whereUserId($id));
    }
}
