<?php

namespace App\Domains\Home\Http\Routing;

use App\Domains\Common\Http\Routing\RouteRegistrar;
use App\Domains\Home\Http\Controllers\HomeController;
use Illuminate\Contracts\Routing\Registrar;

class HomeRoutesRegistrar extends RouteRegistrar
{
    protected array $middlewares = ['web', 'auth'];

    public function map(Registrar $route): void
    {
        $route->get('/', [HomeController::class, 'index'])->name('home');
    }
}
