<?php
namespace Tests;

use App\Services\LocaleService;

final class LocaleServiceTest extends TestCase {

	public function testLocaleStructure(): void {
		$locales = (new LocaleService())->locales();
		$this->assertArrayHasKey('name', $locales['en']);
		$this->assertArrayHasKey('flag-icon', $locales['en']);
	}
}
