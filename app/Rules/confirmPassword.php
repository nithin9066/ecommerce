<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class confirmPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $cPassword;
    public function __construct($cPassword)
    {
        $this->cPassword = $cPassword;
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
        if($value == $this->cPassword)
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The password confirmation does not match.';
    }
}
