<?php
namespace Tests\Feature;

use App\Models\User;

describe('GET /', function (): void {
	test('-> /{locale}/login for guests', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/')->assertRedirect('/en/login');
	});
	test('-> /{locale}/account/entities for users', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/')->assertRedirect('/en/account/entities');
	});
});

describe('GET /{locale}', function (): void {
	test('-> /{locale}/login for guests', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en')->assertRedirect('/en/login');
	});

	test('-> /{locale}/account/entities for users', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en')->assertRedirect('/en/account/entities');
	});
});

describe('GET /{locale}/account', function (): void {
	test('-> /{locale}/account/entities for users', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'));
		$this->get('/en/account')->assertRedirect('/en/account/entities');
		$this->get('/de/account')->assertRedirect('/de/account/entities');
	});

	test('-> /{locale}/login for guests', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account')->assertRedirect('/en/login');
		$this->get('/de/account')->assertRedirect('/de/login');
	});
});

describe('GET /{locale}/settings', function (): void {
	test('-> /{locale}/settings/password for users', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'));
		$this->get('/en/settings')->assertRedirect('/en/settings/password');
		$this->get('/de/settings')->assertRedirect('/de/settings/password');
	});

	test('-> /{locale}/login for guests', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/settings')->assertRedirect('/en/login');
		$this->get('/de/settings')->assertRedirect('/de/login');
	});
});

test('GET /{locale}/login -> /{locale}/account for users', function (): void {
	/** @var \Tests\TestCase $this */
	$this->actingAs(User::findByEmail('user-1@example.com'));
	$this->get('/en/login')->assertRedirect('/en/account');
	$this->get('/de/login')->assertRedirect('/de/account');
});

test('should redirect to "/<route>" when accessing "/<route>/"', function (): void {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});

test('should redirect to "/<route>" when accessing "///<route>///"', function (): void {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});
