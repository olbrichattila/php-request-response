<?php

declare(strict_types=1);

namespace Aolbrich\RequestResponse;

use Aolbrich\PhpDiContainer\Container;
use Aolbrich\RequestResponse\Http\Request\Request;
use Aolbrich\RequestResponse\Http\Response\Response;

class RequestResponse
{
    public static function initiate(
        bool $singleton = true,
        Container $container = null
    ): array {
        $container = $container ?? new Container();

        if ($singleton == true) {
            $request = $container->singleton(Request::class);
            $response = $container->singleton(Response::class);
            
            return [$request, $response];
        }

        $request = $container->get(Request::class);
        $response = $container->get(Response::class);

        return [$request, $response];
    }

    public static function initiateJson(
        bool $singleton = true,
        Container $container = null
    ): array {
        $container = $container ?? new Container();

        if ($singleton == true) {
            $request = $container->singleton(Request::class);
            $response = $container->singleton(Response::class);
            
            return [$request, $response];
        }

        $request = $container->get(Request::class);
        $response = $container->get(Response::class);

        return [$request, $response];
    }
}
