<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobProgress extends Model
{
    protected $table = 'job_progress';

    protected $fillable = [
        'key',
        'progress',
        'status'
    ];
}
