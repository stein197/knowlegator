<?php
namespace App\Providers;

use App\Records\MenuRecord;
use App\Services\MenuService;
use Illuminate\Support\ServiceProvider;

final class MenuProvider extends ServiceProvider {

	public function register(): void {
		$this->app->singleton('menu', MenuService::class);
		/** @var MenuService */
		$menuService = $this->app->get('menu');

		$menuService->register('main', fn (): array => [
			new MenuRecord(
				title: __('menu.main.account'),
				link: lroute('account'),
				icon: 'person-circle'
			),
			new MenuRecord(
				title: __('menu.main.settings'),
				link: lroute('settings'),
				icon: 'gear-fill'
			),
		]);

		$menuService->register('settings', fn (): array => [
			new MenuRecord(
				title: __('page.settings.password.title'),
				link: lroute('settings.password')
			),
			new MenuRecord(
				title: __('page.settings.theme.title'),
				link: lroute('settings.theme')
			),
			new MenuRecord(
				title: __('page.settings.delete.title'),
				link: lroute('settings.delete')
			)
		]);

		$menuService->register('account', fn (): array => [
			new MenuRecord(
				title: __('page.account.entity-list.title'),
				link: lroute('account.entity-list')
			),
			new MenuRecord(
				title: __('page.account.tag-list.title'),
				link: lroute('account.tag-list')
			)
		]);
	}
}
