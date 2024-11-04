<?php
namespace Tests\Unit;

use App\Records\MenuRecord;
use function classname;

describe('lroute()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$app = $this->createApplication();
		$app->setLocale('en');
		$this->assertSame('/en/settings/password', lroute('settings.password'));
		$app->setLocale('de');
		$this->assertSame('/de/settings/password', lroute('settings.password'));
		$app->setLocale('ru');
		$this->assertSame('/ru/settings/password', lroute('settings.password'));
	});

	test('should accept parameters', function (): void {
		/** @var \Tests\TestCase $this */
		$app = $this->createApplication();
		$app->setLocale('en');
		$uuid = fake()->uuid();
		$this->assertSame("/en/account/tags/{$uuid}", lroute('account.tag.read', ['id' => $uuid]));
	});
});

describe('to_lroute()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$app = $this->createApplication();
		$app->setLocale('en');
		$this->assertStringEndsWith('/en/settings/password', to_lroute('settings.password')->getTargetUrl());
		$app->setLocale('de');
		$this->assertStringEndsWith('/de/settings/password', to_lroute('settings.password')->getTargetUrl());
		$app->setLocale('ru');
		$this->assertStringEndsWith('/ru/settings/password', to_lroute('settings.password')->getTargetUrl());
	});
});

describe('classname()', function (): void {
	test('should return empty string when there are no arguments', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('', classname());
	});

	test('should accept string varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a b c', classname('a', 'b', 'c'));
	});

	test('should accept null varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('', classname(null, null));
	});

	test('should accept array varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a', 'b', 'c', classname(['a'], ['b', 'c']));
	});

	test('should accept array with nulls varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a', 'b', 'c', classname(['a', null], ['b', 'c']));
	});

	test('should accept map varags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a c', classname(['a' => true, 'b' => false, 'c' => true]));
	});

	test('should accept string, array, map and nulls varargs', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('a b c', classname('a', null, ['b', null], null, ['c' => true, 'd' => false]));
	});
});
