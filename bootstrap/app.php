<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__.'/../routes/web.php',
		health: '/up',
	)
	->withMiddleware(function (Middleware $middleware): void {
		$middleware->redirectGuestsTo(fn (): string => route('login', ['locale' => app()->getLocale()]));
		$middleware->redirectUsersTo(fn (): string => route('account', ['locale' => app()->getLocale()]));
	})
	->withExceptions()
	->create();
