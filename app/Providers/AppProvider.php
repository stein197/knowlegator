<?php
namespace App\Providers;

use App\Services\ThemeService;
use Illuminate\Support\ServiceProvider;

class AppProvider extends ServiceProvider {

	public function register(): void {
		$this->app->singleton('theme', ThemeService::class);
	}
}
