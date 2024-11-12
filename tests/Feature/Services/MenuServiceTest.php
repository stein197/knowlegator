<?php
namespace Tests\Feature\Services;

use App\Records\MenuRecord;

test('should work', function (): void {
	/** @var \Tests\TestCase $this */
	$app = $this->createApplication();
	/** @var \App\Services\MenuService */
	$menuService = $app->makeWith('menu', ['request' => $app->get('request')->create('/en/account/tags/create')]);
	$menuService->register('menu', fn (): array => [
		new MenuRecord(
			title: 'Item 1',
			link: '/en/account/entities'
		),
		new MenuRecord(
			title: 'Item 2',
			link: '/en/account/tags'
		),
		new MenuRecord(
			title: 'Item 2.1',
			link: '/en/account/tags/create'
		)
	]);
	$menu = [...$menuService->get('menu')];
	$this->assertTrue($menu[0]->equals(new MenuRecord(
		title: 'Item 1',
		link: '/en/account/entities',
		icon: '',
		active: false
	)));
	$this->assertTrue($menu[1]->equals(new MenuRecord(
		title: 'Item 2',
		link: '/en/account/tags',
		icon: '',
		active: true
	)));
	$this->assertTrue($menu[2]->equals(new MenuRecord(
		title: 'Item 2.1',
		link: '/en/account/tags/create',
		icon: '',
		active: true
	)));
});

test('should mark active menu item where there is a search query in a request', function (): void {
	/** @var \Tests\TestCase $this */
	$app = $this->createApplication();
	/** @var \App\Services\MenuService */
	$menuService = $app->makeWith('menu', ['request' => $app->get('request')->create('/en/account/tags?q=')]);
	$menuService->register('menu', fn (): array => [
		new MenuRecord(
			title: 'Item 1',
			link: '/en/account/tags'
		)
	]);
	[$mRecord] = [...$menuService->get('menu')];
	$this->assertTrue($mRecord->equals(new MenuRecord(
		title: 'Item 1',
		link: '/en/account/tags',
		icon: '',
		active: true
	)));
});
