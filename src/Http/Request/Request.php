<?php

declare(strict_types=1);

namespace Aolbrich\RequestResponse\Http\Request;

use Aolbrich\RequestResponse\Http\Request\Validator\RequestValidator;
use Closure;

//@todo these requests may go to another library, and will be imported, injected
class Request implements RequestInterface
{
    protected array $validationErrors = [];

    public function __construct(protected readonly RequestValidator $requestValidator)
    {
    }
    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function body(): string
    {
        return @file_get_contents('php://input');
    }

    public function jsonBody(): ?array
    {
        return json_decode($this->body(), true);
    }

    public function params(): array
    {
        $getParams = $_GET ?? [];
        $postParams = $_POST ?? [];
        $mergedResult = array_merge($getParams, $postParams);

        return $this->sanitaze($mergedResult);
    }

    public function validate(array $validationRules): array
    {
        $validator = $this->requestValidator->validate($this, $validationRules);
        $this->validationErrors = $validator->validationErrors();

        return $validator->validated();
    }

    public function validationErrors(): array
    {
        return $this->validationErrors;
    }


    public function setRule(string $ruleName, string|callable|Closure $rule): void
    {
        $this->requestValidator->setRule($ruleName, $rule);
    }
    
    protected function sanitaze(array $params): array
    {
        return array_reduce(array_keys($params), function (array $accumulator, string $key) use ($params) {
            $accumulator[$key] = filter_var($params[$key], FILTER_SANITIZE_STRING);
            return $accumulator;
        }, []);
    }
}
