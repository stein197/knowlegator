<?php
namespace App\Providers;

use App\Services\BreadcrumbService;
use Illuminate\Support\ServiceProvider;

class BreadcrumbProvider extends ServiceProvider {

	public function register(): void {
		$this->app->singleton('breadcrumb', BreadcrumbService::class);
	}
}
