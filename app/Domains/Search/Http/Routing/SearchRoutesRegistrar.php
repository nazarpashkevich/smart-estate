<?php

namespace App\Domains\Search\Http\Routing;

use App\Domains\Common\Http\Routing\RouteRegistrar;
use App\Domains\Search\Http\Controllers\SearchController;
use Illuminate\Contracts\Routing\Registrar;

class SearchRoutesRegistrar extends RouteRegistrar
{
    protected array $middlewares = ['web'];

    public function map(Registrar $route): void
    {
        $route->group([
            'middleware' => $this->getMiddlewares(),
            'prefix'     => $this->getPrefix() . '/search',
            'controller' => SearchController::class,
        ], static function (Registrar $route) {
            $route->get('', 'index')->name('search.index');
        });
    }
}
