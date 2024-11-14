<?php
namespace App\Providers;

use App\Services\LocaleService;
use App\Services\ThemeService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppProvider extends ServiceProvider {

	public function register(): void {
		$this->app->singleton('theme', ThemeService::class);
		$this->app->singleton('locale', LocaleService::class);
	}

	// TODO: Extract @null, @notnull to a library
	public function boot(): void {
		Blade::if('null', fn (mixed $value): bool => $value === null);
		Blade::if('notnull', fn (mixed $value): bool => $value !== null);
	}
}
