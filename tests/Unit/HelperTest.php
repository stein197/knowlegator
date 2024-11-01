<?php
namespace Tests\Unit;

use App\MenuItem;
use Illuminate\Http\Request;
use Tests\TestCase;

final class HelperTest extends TestCase {

	public function testLrouteShouldWork(): void {
		$app = $this->createApplication();
		$app->setLocale('en');
		$this->assertSame('/en/settings/password', lroute('settings.password'));
		$app->setLocale('de');
		$this->assertSame('/de/settings/password', lroute('settings.password'));
		$app->setLocale('ru');
		$this->assertSame('/ru/settings/password', lroute('settings.password'));
	}

	public function testTo_lrouteShouldWork(): void {
		$app = $this->createApplication();
		$app->setLocale('en');
		$this->assertStringEndsWith('/en/settings/password', to_lroute('settings.password')->getTargetUrl());
		$app->setLocale('de');
		$this->assertStringEndsWith('/de/settings/password', to_lroute('settings.password')->getTargetUrl());
		$app->setLocale('ru');
		$this->assertStringEndsWith('/ru/settings/password', to_lroute('settings.password')->getTargetUrl());
	}

	public function testMenuShouldReturnRegisteredMenu(): void {
		$menuItem = new MenuItem(
			title: 'Test Title',
			link: '/test/link',
			routeName: 'test.route',
			active: true
		);
		menu('test', fn (Request $request): array => [$menuItem]);
		$this->assertEquals([$menuItem], menu('test'));
	}
	
	public function testMenuShouldReturnNullWhenMenuIsNotRegistered(): void {
		$this->assertNull(menu('Undefined Menu'));
	}
}
