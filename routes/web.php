<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckLocaleMiddleware;
use App\Http\Middleware\TrimTrailingSlashMiddleware;

Route::get('/{locale}/login', LoginController::class)
	->middleware([
		TrimTrailingSlashMiddleware::class,
		CheckLocaleMiddleware::class
	])
	->name('login');

// Redirects
Route::get('/', fn () => redirect()->route('login', ['locale' => app()->getLocale()]));
