<?php

namespace App\Rules;

use Modules\Account\Models\User;
use Illuminate\Contracts\Validation\Rule;

class UniqueMetaValue implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        public $classname,
        public string $key,
        public $value = false
    ) {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value == $this->value || $this->classname::whenTrashed(true)->whereMeta($this->key, '=', $value)->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Mohon maaf, :attribute telah digunakan.';
    }
}
