<?php

namespace Aolbrich\RequestResponse\Http\Request\Validator;

use Aolbrich\RequestResponse\Http\Request\RequestInterface;

interface RequestValidatorInterface
{
    public function validate(RequestInterface $request, array $validationRules): RequestValidatorInterface;
    public function validated(): array;
    public function validationErrors(): array;
}
