<?php
namespace Tests\Services;

use App\Enum\Theme;
use App\Services\ThemeService;
use Tests\TestCase;

pest()->extend(TestCase::class);

it('should return null for the first get() call', function (): void {
	/** @var \Tests\TestCase $this */
	$app = $this->createApplication();
	$themeService = $app->get(ThemeService::class);
	$this->assertNull($themeService->get());
});

it('should return saved value for the get() call after calling set()', function (): void {
	/** @var \Tests\TestCase $this */
	$app = $this->createApplication();
	$themeService = $app->get(ThemeService::class);
	$themeService->set(Theme::Light);
	$this->assertSame(Theme::Light, $themeService->get());
	$themeService->set(Theme::Dark);
	$this->assertSame(Theme::Dark, $themeService->get());
});
