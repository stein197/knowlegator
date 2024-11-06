<?php
namespace App\Providers;

use App\Records\BreadcrumbRecord;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use function explode;
use function path_split;
use function singularize;

class BreadcrumbProvider extends ServiceProvider {

	public function register(): void {
		$this->app->singleton('breadcrumb', BreadcrumbService::class);
		/** @var BreadcrumbService */
		$breadcrumb = $this->app->get('breadcrumb');

		$breadcrumb->register('settings', function (Request $request): iterable {
			$path = path_split($request->getRequestUri());
			if ($path[1] !== 'settings')
				yield;
			yield new BreadcrumbRecord(__('page.settings.title'));
			if (isset($path[2]))
				yield new BreadcrumbRecord(__("page.settings.{$path[2]}.title"));
		});

		$breadcrumb->register('account', function (Request $request): iterable {
			$path = path_split($request->getRequestUri());
			if ($path[1] !== 'account')
				yield;
			yield new BreadcrumbRecord(__('page.account.title'));
			if (isset($path[2]))
				yield new BreadcrumbRecord(__('resource.' . singularize($path[2]) . '.index.title'), lroute("{$path[2]}.index"));
			if (isset($path[3])) {
				[$type, $action] = explode('.', $request->route()->getName());
				yield new BreadcrumbRecord(__('resource.' . singularize($type) . ".{$action}.title"));
			}
		});
	}
}
