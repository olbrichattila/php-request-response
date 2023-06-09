<?php

declare(strict_types=1);

namespace Aolbrich\RequestResponse\Http\Request;

class MockRequest implements RequestInterface
{
    private string $uri = '/';
    private string $method = 'GET';
    private array $params = [];
    public function getUri(): string
    {
        return $this->uri;
    }

    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    public function body(): string
    {
        return "";
    }
    public function jsonBody(): ?array
    {
        return null;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function params(): array
    {
        return $this->params;
    }
}
