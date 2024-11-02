<?php
use App\Http\Controllers\Account\AccountEntityListController;
use App\Http\Controllers\Account\AccountTagListController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Settings\SettingsDeleteController;
use App\Http\Controllers\Settings\SettingsPasswordController;
use App\Http\Controllers\Settings\SettingsThemeController;
use App\Http\Middleware\CheckLocaleMiddleware;
use App\Http\Middleware\DefaultLocaleMiddleware;
use App\Http\Middleware\RedirectMiddleware;
use App\Http\Middleware\TrimSlashesMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/{locale}'], function (): void {
	Route::middleware([TrimSlashesMiddleware::class, DefaultLocaleMiddleware::class, CheckLocaleMiddleware::class])->group(function (): void {
		Route::middleware(RedirectIfAuthenticated::class)->group(function (): void {
			Route::get('/login', [LoginController::class, 'get'])->name('login');
			Route::post('/login', [LoginController::class, 'post']);
		});
		Route::middleware(Authenticate::class)->group(function (): void {
			Route::post('/logout', LogoutController::class)->name('logout');
			Route::prefix('/account')->group(function (): void {
				Route::get('/', AccountController::class)->name('account');
				Route::get('/entities', AccountEntityListController::class)->name('account.entity-list');
				Route::prefix('/tags')->group(function (): void {
					Route::get('/', AccountTagListController::class)->name('account.tag-list');
				});
			});
			Route::prefix('/settings')->group(function (): void {
				Route::get('/', SettingsController::class)->name('settings');
				Route::prefix('/password')->group(function (): void {
					Route::get('/', [SettingsPasswordController::class, 'get'])->name('settings.password');
					Route::put('/', [SettingsPasswordController::class, 'put']);
				});
				Route::prefix('/delete')->group(function (): void {
					Route::get('/', [SettingsDeleteController::class, 'get'])->name('settings.delete');
					Route::delete('/', [SettingsDeleteController::class, 'delete']);
				});
				Route::prefix('/theme')->group(function (): void {
					Route::get('/', [SettingsThemeController::class, 'get'])->name('settings.theme');
					Route::post('/', [SettingsThemeController::class, 'post']);
				});
			});
		});
	});
});

Route::middleware(RedirectMiddleware::class)->group(function (): void {
	Route::get('/');
	Route::get('/{locale}');
});
