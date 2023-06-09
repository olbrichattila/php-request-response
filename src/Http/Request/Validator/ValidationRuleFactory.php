<?php

// @TODO add setter to be able to set custom config validation rule classes

declare(strict_types=1);

namespace Aolbrich\RequestResponse\Http\Request\Validator;

use Aolbrich\RequestResponse\Http\Request\Validator\ValidationRuleInterface;
use Aolbrich\RequestResponse\Http\Request\Validator\Config\RequestValidatorConfig;
use Aolbrich\RequestResponse\Http\Request\Validator\Rules\Exception\RequestValidationRuleException;
use Closure;

class ValidationRuleFactory
{
    public function __construct(protected readonly RequestValidatorConfig $requestValidatorConfig)
    {
    }

    public function rule(string $ruleName): ValidationRuleInterface|Closure
    {
        $ruleClass = $this->getValidationRuleByName($ruleName);
        if ($ruleClass) {
            if($ruleClass instanceof Closure) {
              return $ruleClass;
            } 
            return new $ruleClass();
        }

        throw new RequestValidationRuleException('Validation rule ' . $ruleName . ' not exists!');
    }

    public function setRule(string $ruleName, string|callable|Closure $rule): void
    {
        $this->requestValidatorConfig->setRule($ruleName, $rule);
    }

    protected function getValidationRuleByName(string $ruleName): string|Closure|callable|null
    {
        $config = $this->requestValidatorConfig->getConfig();

        return $config[$ruleName] ?? null;
    }
}
