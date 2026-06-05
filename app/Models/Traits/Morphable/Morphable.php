<?php 

namespace App\Models\Traits\Morphable;

trait Morphable
{
	/**
	 * Get the statically morphable_type properties.
	 */
	public static function getMorphableTypes($morphs, $attribute = false)
	{
		return $attribute ? collect(self::${'morphs_'.$morphs})->map(fn ($type, $model) => $type[$attribute]) : collect(self::${'morphs_'.$morphs});
	}

	/**
	 * Get morphable_id from morphable_type.
	 */
	public static function allMorphableIds($morphs, string $search = '')
	{
	    foreach(self::${'morphs_'.$morphs} as $model => $type) {
	        $result[$type['name']] = $model::with($type['with'] ?? [])->where($type['where'] ?? [])->search($search)->get()->pluck(($type['getter'] ?? 'name'), 'id');
	    }

	    return $result;
	}

	/**
	 * Get target attribute.
	 */
	public function getMorphableName(string $morphs = 'morphable')
	{
		$type = self::${'morphs_'.$morphs}[$this->{$morphs.'_type'}];
		return data_get($this->{$morphs}, $type['getter'] ?? 'name');
	}
}
