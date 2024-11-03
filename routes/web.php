<?php
use App\Http\Controllers\Account\EntityListController;
use App\Http\Controllers\Account\TagController;
use App\Http\Controllers\Account\TagListController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Settings\DeleteController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ThemeController;
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
				Route::get('/entities', EntityListController::class)->name('account.entity-list');
				Route::prefix('/tags')->group(function (): void {
					Route::get('/', TagListController::class)->name('account.tag-list');
					Route::get('/create', [TagController::class, 'showCreate'])->name('account.tag.create');
					Route::post('/create', [TagController::class, 'create']);
					Route::get('/{id}', [TagController::class, 'read'])->name('account.tag.read')->whereUuid('id');
					Route::put('/{id}', [TagController::class, 'update'])->whereUuid('id');
					Route::get('/{id}/delete', [TagController::class, 'showDelete'])->name('account.tag.delete')->whereUuid('id');
					Route::delete('/{id}', [TagController::class, 'delete'])->whereUuid('id');
				});
			});
			Route::prefix('/settings')->group(function (): void {
				Route::get('/', SettingsController::class)->name('settings');
				Route::prefix('/password')->group(function (): void {
					Route::get('/', [PasswordController::class, 'get'])->name('settings.password');
					Route::put('/', [PasswordController::class, 'put']);
				});
				Route::prefix('/delete')->group(function (): void {
					Route::get('/', [DeleteController::class, 'get'])->name('settings.delete');
					Route::delete('/', [DeleteController::class, 'delete']);
				});
				Route::prefix('/theme')->group(function (): void {
					Route::get('/', [ThemeController::class, 'get'])->name('settings.theme');
					Route::post('/', [ThemeController::class, 'post']);
				});
			});
		});
	});
});

Route::middleware(RedirectMiddleware::class)->group(function (): void {
	Route::get('/');
	Route::get('/{locale}');
});
