<?php

declare(strict_types=1);

namespace Aolbrich\RequestResponse\Http\Request\Validator\Rules;

use Aolbrich\RequestResponse\Http\Request\Validator\ValidationRuleInterface;

class MaximumLengthValidationRule extends ValidationRuleBase implements ValidationRuleInterface
{
    private string $validationParam;

    public function applyRule(mixed $value, string $validationParam = ''): bool
    {
        $this->validationParam = $validationParam;

        return strlen((string) $value) <= intval($validationParam);
    }

    public function message(): string
    {
        return "The value should maximum {$this->validationParam} characters long";
    }
}
