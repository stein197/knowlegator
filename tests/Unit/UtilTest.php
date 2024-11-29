<?php
namespace Tests\Util;

use function App\{
	array_entries,
    array_from_entries,
    array_get_last,
    class_get_name,
    path_split
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

describe('array_from_entries()', function (): void {
	test('should return an empty array when the array is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame([], array_from_entries([]));
	});

	test('should return an array from entries', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame(['a' => 1], array_from_entries([['a', 1]]));
	});
});

describe('array_get_last()', function (): void {
	test('should return the last element', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('c', array_get_last(['a', 'b', 'c']));
	});

	test('should return null when the array is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertNull(array_get_last([]));
	});
});

describe('class_get_name()', function (): void {
	test('should return classname when the class is namespaced', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('Controller', class_get_name('App\\Http\\Controller'));
	});

	test('should return the same string when the classname is not namespaced', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('App', class_get_name('App'));
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
