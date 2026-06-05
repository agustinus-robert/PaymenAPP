<?php

namespace App\Models;

use App\Enums\PositionLevelEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departement;
use App\Models\Traits\Metable\Metable;
use App\Models\Traits\Restorable\Restorable;
use App\Models\Traits\Searchable\Searchable;

class Position extends Model
{
    use Restorable, Searchable, Metable;

    /**
     * The table associated with the model.
     */
    protected $table = 'cmp_positions';

    /**
     * Define the meta table
     */
    protected $metaTable = 'cmp_position_meta';

    /**
     * Define the meta key name
     */
    public $metaKeyName = 'position_id';

    /**
     * Prevent meta from being populated
     */
    public $hideMeta = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kd',
        'name',
        'description',
        'level',
        'dept_id',
        'is_visible',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'level' => PositionLevelEnum::class
    ];

    /**
     * The attributes that define value is a instance of carbon.
     */
    protected $dates = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    /**
     * belongs to user.
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'dept_id')->withDefault();
    }

    /**
     * This belongs to many parents.
     */
    public function parents()
    {
        return $this->belongsToMany(self::class, 'cmp_position_trees', 'position_id', 'parent_id')->orderBy('level');
    }

    /**
     * This belongs to many children.
     */
    public function children()
    {
        return $this->belongsToMany(self::class, 'cmp_position_trees', 'parent_id', 'position_id')->orderBy('level');
    }

    /**
     * Scope visible.
     */
    public function scopeVisibility($query, $bool = true)
    {
        return $query->whereIsVisible($bool ? 1 : 0);
    }

    /**
     * When department id.
     */
    public function scopeWhenDepartmentId($query, $department)
    {
        return $query->when((bool) $department, fn ($subquery) => $subquery->whereDeptId($department));
    }
}
