<?php
namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Depends;
use Tests\TestCase;
use function array_combine;
use function array_filter;
use function array_map;
use function file_exists;
use function file_get_contents;
use function is_dir;
use function join;
use function json_decode;
use function preg_match_all;
use function preg_replace;
use function scandir;
use function sizeof;
use const DIRECTORY_SEPARATOR;

final class LangTest extends TestCase {

	public function testLangFolderExists(): void {
		$path = $this->getPath();
		$this->assertTrue(file_exists($path) && is_dir($path));
	}

	#[Depends('testLangFolderExists')]
	public function testDefaultLocaleShouldExist(): void {
		$this->assertTrue(file_exists($this->getPath() . DIRECTORY_SEPARATOR . $this->getDefaultLocale() . '.json'));
	}

	#[Depends('testLangFolderExists')]
	public function testAllLocalesShouldBeDefined(): void {
		[$defaultLocale, $localeArray] = $this->getLocales();
		$sizeDefaultLocale = sizeof($defaultLocale);
		foreach ($localeArray as $lang => $locale) {
			$sizeLocale = sizeof($locale);
			$this->assertEquals($sizeDefaultLocale, $sizeLocale, "The lang '{$lang}' contains unmatched translations (expected: {$sizeDefaultLocale}, actual: {$sizeLocale})");
			foreach ($defaultLocale as $k => $v)
				$this->assertArrayHasKey($k, $locale, "The lang '{$lang}' should contain the key '{$k}'");
		}
	}

	#[Depends('testAllLocalesShouldBeDefined')]
	public function testLocalesShouldDefineAllPlaceholders(): void {
		[$defaultLocale, $localeArray] = $this->getLocales();
		$defaultLocalePlaceholders = [];
		foreach ($defaultLocale as $k => $v)
			$defaultLocalePlaceholders[$k] = self::parseParameters($v);
		foreach ($localeArray as $lang => $locale) {
			foreach ($locale as $k => $v)
				$this->assertArrayIsEqualToArrayIgnoringListOfKeys($defaultLocalePlaceholders[$k], self::parseParameters($v), [], "The locale '{$lang}' at key '{$k}' does not match the parameters: " . join(', ', $defaultLocalePlaceholders[$k]));
		}
	}

	private function getLocales(): array {
		$path = base_path('lang');
		$langs = array_map(
			fn (string $file): string => preg_replace('/\\.json$/', '', $file),
			array_filter(
				scandir($path),
				fn (string $name): bool => $name !== '.' && $name !== '..'
			)
		);
		$result = array_combine(
			$langs,
			array_map(
				fn (string $name): array => json_decode(
					file_get_contents($path . DIRECTORY_SEPARATOR . $name . '.json'),
					true
				),
				$langs
			)
		);
		$defaultJson = $result[$this->getDefaultLocale()];
		unset($result[$this->getDefaultLocale()]);
		return [$defaultJson, $result];
	}

	private function getPath(): string {
		return base_path('lang');
	}

	private function getDefaultLocale(): string {
		return config('app.locale');
	}

	private static function parseParameters(string $message): array {
		$match = [];
		preg_match_all('/(?<=:)[a-zA-Z0-9_]+/', $message, $match);
		return $match[0];
	}
}
