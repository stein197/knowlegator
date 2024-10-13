<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckLocaleMiddleware;

Route::redirect('/', '/' . app()->getLocale());
Route::get('/{locale}', MainController::class)
	->middleware(CheckLocaleMiddleware::class)
	->name('main');
