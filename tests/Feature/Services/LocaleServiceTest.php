<?php
namespace Tests\Feature\Services;

use App\Services\LocaleService;

test('locale structure', function (): void {
	/** @var \Tests\TestCase $this */
	$localeService = new LocaleService();
	$locales = $localeService->locales();
	$this->assertArrayHasKey('name', $locales['en']);
	$this->assertArrayHasKey('flag-icon', $locales['en']);
});

test('exists returns true for en', function (): void {
	/** @var \Tests\TestCase $this */
	$localeService = new LocaleService();
	$this->assertTrue($localeService->exists('en'));
});

test('exists returns false for unknown locale', function (): void {
	/** @var \Tests\TestCase $this */
	$localeService = new LocaleService();
	$this->assertFalse($localeService->exists('unknown'));
});
