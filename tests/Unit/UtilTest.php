<?php
namespace Tests\Util;

use function App\{
	array_entries,
	array_unset,
	path_split,
};

describe('array_entries()', function (): void {
	test('should return an empty array when the array is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame([], array_entries([]));
	});

	test('should return array entries', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame([['a', 1]], array_entries(['a' => 1]));
	});
});

describe('path_split()', function (): void {
	test('should return an empty array when the path is root', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertEmpty(path_split('/'));
	});

	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame(['en'], path_split('/en'));
		$this->assertSame(['en', 'settings'], path_split('/en/settings/'));
	});
});
