<?php
class Traffic extends Model
{
    protected $fillable = ['visitor' , 'visits'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($traffic) {
            if ($traffic->visits) {
                $traffic->visits++;
            }
        });
    }
}