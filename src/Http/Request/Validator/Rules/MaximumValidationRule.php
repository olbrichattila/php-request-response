<?php

declare(strict_types=1);

namespace Aolbrich\RequestResponse\Http\Request\Validator\Rules;

use Aolbrich\RequestResponse\Http\Request\Validator\ValidationRuleInterface;

class MaximumValidationRule extends ValidationRuleBase implements ValidationRuleInterface
{
    private string $validationParam;
    public function applyRule(mixed $value, string $validationParam = ''): bool
    {
        $this->validationParam = $validationParam;

        return $value <= $validationParam;
    }

    public function message(): string
    {
        return "Value should be less or equal then {$this->validationParam}";
    }
}
