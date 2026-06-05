<?php

namespace App\Http\Requests;

use Illuminate\Support\Collection;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
	/**
	 * Transform request into expected output.
	 */
	public function transform()
	{
		return $this->all();
	}

	/**
	 * Getting transformed request based on transform methods.
	 */
	public function transformed() : FormRequest
	{
		return $this->merge($this->transform());
	}

	/**
	 * Array casting based on transform methods.
	 */
	public function toArray() : array
	{
		return $this->only(array_keys($this->transform()));
	}

	/**
	 * Collection casting based on transform methods.
	 */
	public function toCollection() : Collection
	{
		return collect($this->toArray());
	}
}