<?php
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Resource\EntityController;
use App\Http\Controllers\Resource\ETypeController;
use App\Http\Controllers\Resource\TagController;
use App\Http\Controllers\Settings\DeleteController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ThemeController;
use App\Http\Middleware\CheckLocaleMiddleware;
use App\Http\Middleware\DefaultLocaleMiddleware;
use App\Http\Middleware\TrimSlashesMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/{locale}'], function (): void {
	Route::middleware([TrimSlashesMiddleware::class, DefaultLocaleMiddleware::class, CheckLocaleMiddleware::class])->group(function (): void {
		Route::put('/theme', ThemeController::class)->name('theme');
		Route::middleware(RedirectIfAuthenticated::class)->group(function (): void {
			Route::get('/login', [LoginController::class, 'get'])->name('login');
			Route::post('/login', [LoginController::class, 'post']);
		});
		Route::middleware(Authenticate::class)->group(function (): void {
			Route::post('/logout', LogoutController::class)->name('logout');
			Route::prefix('/account')->group(function (): void {
				Route::resources([
					'entities' => EntityController::class,
					'etypes' => ETypeController::class,
					'tags' => TagController::class
				]);
			});
			Route::prefix('/settings')->group(function (): void {
				Route::prefix('/password')->group(function (): void {
					Route::get('/', [PasswordController::class, 'get'])->name('settings.password');
					Route::put('/', [PasswordController::class, 'put']);
				});
				Route::prefix('/delete')->group(function (): void {
					Route::get('/', [DeleteController::class, 'get'])->name('settings.delete');
					Route::delete('/', [DeleteController::class, 'delete']);
				});
			});
		});
	});
});

// TODO: Delete account and settings names
// Redirects
Route::get('/', fn (Request $request): RedirectResponse => to_lroute($request->user() ? 'entities.index' : 'login'));
Route::middleware(CheckLocaleMiddleware::class)->group(function (): void {
	Route::get('/{locale}', fn (Request $request): RedirectResponse => to_lroute($request->user() ? 'entities.index' : 'login'));
	Route::get('/{locale}/account', fn (Request $request): RedirectResponse => to_lroute($request->user() ? 'entities.index' : 'login'))->name('account');
	Route::get('/{locale}/settings', fn (Request $request): RedirectResponse => to_lroute($request->user() ? 'settings.password' : 'login'))->name('settings');
});
