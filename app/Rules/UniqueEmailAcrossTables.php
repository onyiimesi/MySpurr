<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueEmailAcrossTables implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existsInTalent = DB::table('talent')->where('email', $value)->exists();
        $existsInBusiness = DB::table('businesses')->where('email', $value)->exists();

        if ($existsInTalent || $existsInBusiness) {
            $fail('The email address is already in use.');
        }
    }
}
