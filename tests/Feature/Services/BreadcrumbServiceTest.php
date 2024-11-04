<?php
namespace Tests\Feature\Services;

use Illuminate\Support\Facades\Request;

test('should work correctly when the depth is 2', function (): void {
	/** @var \Tests\TestCase $this */
	$app = $this->createApplication();
	$list = $app->makeWith('breadcrumb', ['app' => $app, 'request' => Request::create('/en/account/tags')])->list();
	$this->assertSame(['title' => 'Account', 'link' => ''], (array) $list[0]);
	$this->assertSame(['title' => 'Tags', 'link' => ''], (array) $list[1]);
});

test('should work correctly when the depth is 3', function (): void {
	/** @var \Tests\TestCase $this */
	$app = $this->createApplication();
	$list = $app->makeWith('breadcrumb', ['app' => $app, 'request' => Request::create('/en/account/tags/create')])->list();
	$this->assertSame(['title' => 'Account', 'link' => ''], (array) $list[0]);
	$this->assertSame(['title' => 'Tags', 'link' => '/en/account/tags'], (array) $list[1]);
	$this->assertSame(['title' => 'New tag', 'link' => ''], (array) $list[2]);
});
