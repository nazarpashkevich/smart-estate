<?php

namespace App\Domains\Estate\Http\Routing;

use App\Domains\Common\Http\Routing\RouteRegistrar;
use App\Domains\Estate\Http\Controllers\PersonalEstateController;
use Illuminate\Contracts\Routing\Registrar;

class EstateRoutesRegistrar extends RouteRegistrar
{
    protected array $middlewares = ['web'];

    public function map(Registrar $route): void
    {
        // personal user routes
        $route->group([
            'prefix'     => 'personal/estate',
            'controller' => PersonalEstateController::class,
            'middleware' => 'auth',
            'as'         => 'personal.estate.',
        ], static function (Registrar $route) {
            $route->get('', 'index')->name('index');
            $route->get('create', 'create')->name('create');
            $route->get('{estateItem}', 'edit')->name('edit');

            // api
            $route->post('', 'store')->name('store');
            $route->put('{estateItem}', 'update')->name('update');
        });
    }
}
