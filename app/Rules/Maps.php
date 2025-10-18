<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Maps implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^https?:\/\/(www\.)?(maps\.google\.com|google\.com\/maps|maps\.app\.goo\.gl)\/.+$/i';
        if (!preg_match( $pattern, $value)) {
            $fail('Kolom :attribute harus berupa tautan Google Maps yang valid.');
        }
    }
}
