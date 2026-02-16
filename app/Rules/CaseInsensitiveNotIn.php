<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class CaseInsensitiveNotIn implements ValidationRule
{
    use ValidatesAttributes;

    /**
     * @var array
     */
    protected array $values = [];
    private const string FORMAT_FUNCTION = 'strtolower';

    public function __construct(array $values = [])
    {
        $this->values = array_map(self::FORMAT_FUNCTION, $values);
    }

    public function passes($attribute, $value)
    {
        $value = call_user_func(self::FORMAT_FUNCTION, $value);

        return $this->validateNotIn($attribute, $value, $this->values);
    }

    public function message()
    {
        return __('validation.invalid_value');
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Your custom validation logic here
        if ($value === 'expected_value') {
            $fail(':attribute cannot be a reserved term.');
        }
    }
}
