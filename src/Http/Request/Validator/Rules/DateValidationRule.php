<?php

declare(strict_types=1);

namespace Aolbrich\RequestResponse\Http\Request\Validator\Rules;

use Aolbrich\RequestResponse\Http\Request\Validator\ValidationRuleInterface;

class DateValidationRule extends ValidationRuleBase implements ValidationRuleInterface
{
    public function applyRule(mixed $value, string $validationParam = ''): bool
    {
        return (bool) strtotime($value);
    }

    public function message(): string
    {
        return 'Date format is incorrect';
    }
}
