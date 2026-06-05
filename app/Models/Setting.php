<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Setting extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = "app_settings";

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = ['id'];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * Set type attribute.
     */
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = match (true) {
            ($value instanceof Collection) => 'collection',
            ($value instanceof Model) => 'model',
            ($value instanceof Carbon) => 'carbon',
            is_array($value) => 'array',
            is_object($value) => 'object',
            is_double($value) => 'double',
            is_numeric($value) => 'integer',
            default => 'string'
        };
    }

    /**
     * Set value attribute.
     */
    public function setValueAttribute($value)
    {
        $this->setTypeAttribute($value);

        $this->attributes['value'] = match (true) {
            ($value instanceof Collection) => json_encode($value),
            ($value instanceof Model) => get_class($value) . '#' . $value->id,
            ($value instanceof Carbon) => Carbon::parse($value)->format('Y-m-d H:i:s'),
            is_array($value) => json_encode($value),
            is_object($value) => json_encode($value),
            is_double($value) => (float) $value,
            is_numeric($value) => (int) $value,
            default => $value
        };
    }

    /**
     * Get value attribute.
     */
    public function getValueAttribute()
    {
        return match ($this->attributes['type']) {
            'collection' => collect(json_decode($this->attributes['value'], true)),
            'model' => explode('#', $this->attributes['value'])[0]::find(explode('#', $this->attributes['value'])[1]),
            'carbon' => Carbon::parse($this->attributes['value']),
            'array' => json_decode($this->attributes['value'], true),
            'object' => json_decode($this->attributes['value']),
            'double' => (float) $this->attributes['value'],
            'integer' => (int) $this->attributes['value'],
            'string' => $this->attributes['value'],
            default => $this->attributes['value'] ?? null
        };
    }
}
