<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckLocaleMiddleware;
use App\Http\Middleware\TrimTrailingSlashMiddleware;

Route::redirect('/', '/' . app()->getLocale());
Route::get('/{locale}', MainController::class)
	->middleware([
		TrimTrailingSlashMiddleware::class,
		CheckLocaleMiddleware::class
	])
	->name('main');
