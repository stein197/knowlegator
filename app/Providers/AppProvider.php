<?php
namespace App\Providers;

use App\Services\ThemeService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppProvider extends ServiceProvider {

	public function register(): void {
		$this->app->singleton('theme', ThemeService::class);
	}

	// TODO: Extract @null to a library
	public function boot(): void {
		Blade::if('null', fn (mixed $value): bool => $value === null);
	}
}
