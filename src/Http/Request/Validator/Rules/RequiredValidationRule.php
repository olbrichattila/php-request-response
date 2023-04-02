<?php

declare(strict_types=1);

namespace Aolbrich\RequestResponse\Http\Request\Validator\Rules;

use Aolbrich\RequestResponse\Http\Request\Validator\ValidationRuleInterface;

class RequiredValidationRule extends ValidationRuleBase implements ValidationRuleInterface
{
    public function validate(mixed $value, string $validationParam = ''): bool
    {
        return $this->isSet($value);
    }

    public function message(): string
    {
        return 'Required';
    }
}
