<?php

namespace App\Domains\Common\Http\Routing;

use Illuminate\Contracts\Routing\Registrar;

abstract class RouteRegistrar
{
    protected array $middlewares = ['web'];

    protected string $prefix = '';

    abstract public function map(Registrar $route): void;

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }
}
