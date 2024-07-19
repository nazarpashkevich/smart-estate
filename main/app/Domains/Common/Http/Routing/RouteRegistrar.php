<?php

namespace App\Domains\Common\Http\Routing;

use Illuminate\Contracts\Routing\Registrar;

abstract class RouteRegistrar
{
    protected array $middlewares = ['web'];

    protected string $prefix = '';

    public function mapRoutes(Registrar $route): void
    {
        $route->group(['middleware' => $this->getMiddlewares()], fn (Registrar $route) => $this->map($route));
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    abstract public function map(Registrar $route): void;

    public function getPrefix(): string
    {
        return $this->prefix;
    }
}
