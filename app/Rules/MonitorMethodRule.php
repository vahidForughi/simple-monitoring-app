<?php

namespace App\Rules;

use App\Models\Monitor;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MonitorMethodRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, array_keys(Monitor::METHOD))) {
            $fail('The :attribute not valid.');
        }
    }
}
