<?php

namespace App\Domains\Auth\Http\Routing;

use App\Domains\Auth\Http\Controllers\AuthenticatedSessionController;
use App\Domains\Auth\Http\Controllers\ConfirmablePasswordController;
use App\Domains\Auth\Http\Controllers\EmailVerificationNotificationController;
use App\Domains\Auth\Http\Controllers\EmailVerificationPromptController;
use App\Domains\Auth\Http\Controllers\NewPasswordController;
use App\Domains\Auth\Http\Controllers\PasswordController;
use App\Domains\Auth\Http\Controllers\PasswordResetLinkController;
use App\Domains\Auth\Http\Controllers\RegisteredUserController;
use App\Domains\Auth\Http\Controllers\VerifyEmailController;
use App\Domains\Common\Http\Routing\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;

class AuthRouteRegistrar extends RouteRegistrar
{
    public function map(Registrar $route): void
    {
        $route->group(['middleware' => ['guest', ...$this->getMiddlewares()]], static function (Registrar $route) {
            $route->group(
                ['controller' => RegisteredUserController::class, 'prefix' => 'register'],
                static function (Registrar $route) {
                    $route->get('', 'create')->name('register');
                    $route->post('', 'store');
                }
            );

            $route->group(
                ['controller' => AuthenticatedSessionController::class, 'prefix' => 'login'],
                static function (Registrar $route) {
                    $route->get('', 'create')->name('login');
                    $route->post('', 'store');
                }
            );

            $route->group(
                ['controller' => PasswordResetLinkController::class, 'prefix' => 'forgot-password'],
                static function (Registrar $route) {
                    $route->get('', 'create')->name('password.request');
                    $route->post('', 'store')->name('password.email');
                }
            );

            $route->group(['controller' => NewPasswordController::class], static function (Registrar $route) {
                $route->get('reset-password/{token}', 'create')->name('password.reset');
                $route->post('reset-password', 'store')->name('password.store');
            });
        });

        $route->group(['middleware' => 'auth'], static function (Registrar $route) {
            $route->get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

            $route->get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

            $route->post(
                'email/verification-notification',
                [EmailVerificationNotificationController::class, 'store']
            )->middleware('throttle:6,1')
                ->name('verification.send');

            $route->group(['controller' => ConfirmablePasswordController::class], static function (Registrar $route) {
                $route->get('confirm-password', 'show')->name('password.confirm');
                $route->post('confirm-password', 'store');
            });

            $route->put('password', [PasswordController::class, 'update'])->name('password.update');

            $route->post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
        });
    }
}
