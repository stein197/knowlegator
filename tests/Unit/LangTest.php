<?php
namespace Tests;

use PHPUnit\Framework\Attributes\Depends;
use function array_filter;
use function array_map;
use function array_shift;
use function file_exists;
use function file_get_contents;
use function is_dir;
use function json_decode;
use function scandir;
use function sizeof;
use const DIRECTORY_SEPARATOR;

final class LangTest extends TestCase {

	public function testLangFolderExists(): void {
		$path = base_path('lang');
		$this->assertTrue(file_exists($path) && is_dir($path));
	}

	#[Depends('testLangFolderExists')]
	public function testAllLocalesShouldBeDefined(): void {
		$path = base_path('lang');
		$jsonArray = array_map(
			fn (string $name): array => json_decode(
				file_get_contents($path . DIRECTORY_SEPARATOR . $name),
				true
			),
			array_filter(
				scandir(
					$path
				),
				fn (string $name): bool => $name !== '.' && $name !== '..'
			)
		);
		$jsonFirst = array_shift($jsonArray);
		foreach ($jsonArray as $json) {
			$this->assertEquals(sizeof($jsonFirst), sizeof($json));
			foreach ($jsonFirst as $k => $v) {
				$this->assertArrayHasKey($k, $json);
			}
		}
	}
}
