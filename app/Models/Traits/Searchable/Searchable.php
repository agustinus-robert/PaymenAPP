<?php

namespace App\Models\Traits\Searchable;

trait Searchable
{
	/**
	 * Scope search
	 */
	public function scopeSearch ($query, $search = '')
	{
		return $query->when(strlen($search), function ($query) use ($search) {
			return $query->where(function ($subquery) use ($search) {
				if(count($this->searchable ?? [])) {
					foreach($this->searchable as $loop => $column) {
						$cols = explode('.', $column);
						$subquery->when(
							count($cols) == 1, 
							fn ($q) => $q->{$loop == 0 ? 'where' : 'orWhere'}($cols[0], 'like', '%'.$search.'%'),
							function ($q) use ($loop, $cols, $search) {
								$col = array_pop($cols);
								return $q->{$loop == 0 ? 'whereRelation' : 'orWhereRelation'}(implode('.', $cols), $col, 'like', '%'.$search.'%');
							}
						);
					}
				}
				return $subquery;
			});
		});
	}
}