<?php

namespace App\Domains\Dashboard\Http\Routing;

use App\Domains\Common\Http\Routing\RouteRegistrar;
use App\Domains\Dashboard\Http\Controllers\DashboardController;
use Illuminate\Contracts\Routing\Registrar;

class DashboardRouteRegistrar extends RouteRegistrar
{
    protected array $middlewares = ['web', 'auth'];

    public function map(Registrar $route): void
    {
        $route->group(
            ['controller' => DashboardController::class, 'prefix' => 'dashboard'],
            static function (Registrar $route) {
                $route->get('/', 'index')->name('dashboard.index');
            }
        );
    }
}
