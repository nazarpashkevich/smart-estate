<?php

namespace App\Domains\Estate\Http\Routing;

use App\Domains\Common\Http\Routing\RouteRegistrar;
use App\Domains\Estate\Http\Controllers\EstateApplicationController;
use App\Domains\Estate\Http\Controllers\EstateController;
use App\Domains\Estate\Http\Controllers\PersonalEstateController;
use Illuminate\Contracts\Routing\Registrar;

class EstateRoutesRegistrar extends RouteRegistrar
{
    protected array $middlewares = ['web'];

    public function map(Registrar $route): void
    {
        // personal user routes
        $route->group(
            ['prefix' => 'personal', 'middleware' => 'auth', 'as' => 'personal.'],
            static function (Registrar $route) {
                $route->group(
                    ['prefix' => 'estate', 'controller' => PersonalEstateController::class, 'as' => 'estate.',],
                    static function (Registrar $route) {
                        $route->get('', 'index')->name('index');
                        $route->get('create', 'create')->name('create');
                        $route->get('{estateItem}', 'edit')->name('edit');

                        // api
                        $route->post('', 'store')->name('store');
                        $route->put('{estateItem}', 'update')->name('update');
                    }
                );

                $route->group([
                    'prefix' => 'application', 'controller' => EstateApplicationController::class,
                    'as'     => 'application.',
                ], static function (Registrar $route) {
                    $route->get('', 'index')->name('index');
                    $route->post('', 'store')->name('store');
                    $route->put('{estateApplication}/status', 'updateStatus')->name('update-status');
                });
            }
        );

        $route->group([
            'prefix'     => 'estate',
            'controller' => EstateController::class,
            'as'         => 'estate.',
        ], static function (Registrar $route) {
            $route->get('', 'index')->name('index');
            $route->get('{estateItem}', 'show')->name('show');
        });
    }
}
