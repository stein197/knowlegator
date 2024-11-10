<?php
namespace Tests\Feature\Services;

use App\Enum\Theme;
use App\Services\ThemeService;

describe('get()', function (): void {
	test('should return null for the first call', function (): void {
		/** @var \Tests\TestCase $this */
		$app = $this->createApplication();
		$themeService = $app->get(ThemeService::class);
		$this->assertNull($themeService->get());
	});
});

describe('toggle()', function (): void {
	test('get() should return the opposite after calling the toggle()', function (): void {
		/** @var \Tests\TestCase $this */
		$app = $this->createApplication();
		$themeService = $app->get(ThemeService::class);
		$themeService->toggle();
		$this->assertSame(Theme::Dark, $themeService->get());
		$themeService->toggle();
		$this->assertSame(Theme::Light, $themeService->get());
	});
});
