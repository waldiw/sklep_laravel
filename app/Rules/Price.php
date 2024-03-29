<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Price implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $temp = preg_match('#^(0(?!\,00)|[1-9]\d{0,6})\,\d{2}$#', $value);
        // 0(?!\,00) - przed przecinkiem zero, po którym nie występuje ,00
        // |[1-9]\d{0,6} - | oznacza lub i dalej cyfry od 1 do 9 w ilości od 0 do 6
        // \,\d{2} - po przecinku 2 dowolne cyfry
        //dd($temp);
        if($temp == 0) {
            $fail('Pole :attribute musi mieć postać np.: 20,00');
        }
    }
}
