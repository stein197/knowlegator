<?php
namespace Tests\Feature;

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
		$this->assertSame("/en/account/tags/{$uuid}", lroute('tags.show', ['tag' => $uuid]));
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
