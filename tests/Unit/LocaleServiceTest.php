<?php
namespace Tests\Unit;

use App\Services\LocaleService;
use Tests\TestCase;

final class LocaleServiceTest extends TestCase {

	private LocaleService $localeService;

	public function testLocaleStructure(): void {
		$locales = $this->localeService->locales();
		$this->assertArrayHasKey('name', $locales['en']);
		$this->assertArrayHasKey('flag-icon', $locales['en']);
	}

	public function testExistsReturnsTrueForEn(): void {
		$this->assertTrue($this->localeService->exists('en'));
	}

	public function testExistsReturnsFalseForUnknownLocale(): void {
		$this->assertFalse($this->localeService->exists('unknown'));
	}

	protected function setUp(): void {
		$this->localeService = new LocaleService();
	}
}
