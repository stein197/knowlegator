<?php
namespace App\Providers;

use App\Records\MenuRecord;
use App\Services\MenuService;
use Illuminate\Support\ServiceProvider;
use function array_map;

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
				title: __('page.settings.delete.title'),
				link: lroute('settings.delete')
			)
		]);

		$menuService->register('account', fn (): array => [
			new MenuRecord(
				title: __('resource.entity.index.title'),
				link: lroute('entities.index')
			),
			new MenuRecord(
				title: __('resource.etype.index.title'),
				link: lroute('etypes.index')
			),
			new MenuRecord(
				title: __('resource.tag.index.title'),
				link: lroute('tags.index')
			),
			new MenuRecord(
				title: __('page.fields.title'),
				link: lroute('fields')
			)
		]);

		$menuService->register('lang', fn (): array => array_map(fn (array $locale): MenuRecord => new MenuRecord(
			title: $locale['name'],
			link: $locale['url'],
			icon: $locale['flag-icon']
		), $this->app->get('locale')->locales(app()->request)));
	}
}
