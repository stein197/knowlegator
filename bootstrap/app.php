<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		health: '/up',
	)
	->withMiddleware(function (Middleware $middleware): void {
		$group = [
			\Illuminate\Cookie\Middleware\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class
		];
		$middleware->group('web', $group);
		$middleware->redirectGuestsTo(fn (): string => lroute('login'));
		$middleware->redirectUsersTo(fn (): string => lroute('account'));
	})
	->withExceptions()
	->create();
