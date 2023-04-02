<?php

declare(strict_types=1);

namespace Aolbrich\RequestResponse\Http\Request\Validator;

use Aolbrich\RequestResponse\Http\Request\RequestInterface;
use Aolbrich\RequestResponse\Http\Request\Validator\Rules\Exception\RequestValidationRuleException;
use Closure;

class RequestValidator implements RequestValidatorInterface
{
    public function __construct(protected readonly ValidationRuleFactory $validationRuleFactory)
    {
    }
    protected array $validationRules = [];
    protected array $validated = [];
    protected array $validationErrors = [];

    public function validate(
        RequestInterface $request,
        array $validationRules
    ): RequestValidatorInterface {
        $this->validated = [];
        $this->validationErrors = [];
        $params = $request->params();

        foreach ($validationRules as $field => $validationRuleName) {
            $value = $params[$field] ?? null;
            if (is_string($validationRuleName)) {
                $this->applyValidations($params, $value, $field, $validationRuleName);

                continue;
            }
            if (is_callable($validationRuleName)) {
                $validattionMessage = $validationRuleName($value);
                if ($validattionMessage === null) {
                    $this->validated[$field] = $value;
                } else {
                    $this->validationErrors[$field] = $validattionMessage;
                }

                continue;
            }

            throw new RequestValidationRuleException('Incorrect validator provided ' . $validationRuleName);
        }

        return $this;
    }
    public function validated(): array
    {
        return $this->validated;
    }
    public function validationErrors(): array
    {
        return $this->validationErrors;
    }

    public function setRule(string $ruleName, string|callable|Closure $rule): void
    {
        $this->validationRuleFactory->setRule($ruleName, $rule);
    }

    protected function applyValidations(
        array $params,
        mixed $value,
        string $field,
        string $validationRuleName
    ): void {
        $validated = true;
        foreach (explode('|', $validationRuleName) as $splittedRule) {
            if ($this->applyValidation($params, $value, $field, $splittedRule) === false) {
                $validated = false;
            };
        }

        if ($validated === true) {
            $this->validated[$field] = $value;
        }
    }

    protected function applyValidation(
        array $params,
        mixed $value,
        string $field,
        string $validationRuleName
    ): bool {
        $ruleParams = explode(':', $validationRuleName);
        $filteredValidationRuleName = $ruleParams[0];
        $ruleParam = $ruleParams[1] ?? '';
        $validationRule = $this->validationRuleFactory->rule($filteredValidationRuleName);
        if ($validationRule instanceof Closure) {
            $validationResult = $validationRule($value, $ruleParam);
            if ($validationResult === null) {
                return true;
            }
            $this->validationErrors[$field] = $validationResult;
        } else {
            $validationResult = $validationRule->validate($value, $ruleParam);
            if ($validationResult === true) {
                return true;
            }
            $this->validationErrors[$field] = $validationRule->message();
        }

        return false;
    }
}
