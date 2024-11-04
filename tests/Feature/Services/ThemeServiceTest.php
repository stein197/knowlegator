<?php
namespace Tests\Feature\Services;

use App\Enum\Theme;
use App\Services\ThemeService;

test('should return null for the first get() call', function (): void {
	/** @var \Tests\TestCase $this */
	$app = $this->createApplication();
	$themeService = $app->get(ThemeService::class);
	$this->assertNull($themeService->get());
});

test('should return saved value for the get() call after calling set()', function (): void {
	/** @var \Tests\TestCase $this */
	$app = $this->createApplication();
	$themeService = $app->get(ThemeService::class);
	$themeService->set(Theme::Light);
	$this->assertSame(Theme::Light, $themeService->get());
	$themeService->set(Theme::Dark);
	$this->assertSame(Theme::Dark, $themeService->get());
});
