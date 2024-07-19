<?php

namespace App\Domains\User\Http\Routing;

use App\Domains\Common\Http\Routing\RouteRegistrar;
use App\Domains\User\Http\Controllers\ProfileController;
use Illuminate\Contracts\Routing\Registrar;

class UserRouteRegistrar extends RouteRegistrar
{
    protected array $middlewares = ['web', 'auth'];

    public function map(Registrar $route): void
    {
        $route->group(
            ['controller' => ProfileController::class, 'prefix' => 'profile'],
            static function (Registrar $route) {
                $route->get('', 'edit')->name('profile.edit');
                $route->patch('', 'update')->name('profile.update');
                $route->delete('', 'destroy')->name('profile.destroy');
            }
        );
    }
}
