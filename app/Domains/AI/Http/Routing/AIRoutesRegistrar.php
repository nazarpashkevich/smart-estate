<?php

namespace App\Domains\AI\Http\Routing;

use App\Domains\AI\Http\Controllers\ChatController;
use App\Domains\Common\Http\Routing\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;

class AIRoutesRegistrar extends RouteRegistrar
{
    protected array $middlewares = ['web'];

    public function map(Registrar $route): void
    {
        // personal user routes
        $route->group(
            ['prefix' => 'ai', 'as' => 'ai.', 'middleware' => 'auth'],
            static function (Registrar $route) {
                $route->group(
                    ['prefix' => 'chat', 'controller' => ChatController::class, 'as' => 'chat.',],
                    static function (Registrar $route) {
                        $route->get('', 'index')->name('index');
                        $route->get('send', 'send')->name('send');
                    }
                );
            }
        );
    }
}
