<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('GET /{locale}/account should redirect to /{locale}/account/entities for a user', function () {
	/** @var \Tests\TestCase $this */
	$this->actingAs(User::findByEmail('user-1@example.com'));
	$this->get('/en/account')->assertRedirect('/en/account/entities');
});

test('GET /{locale}/settings should redirect to /{locale}/settings/password for a user', function (): void {
	/** @var \Tests\TestCase $this */
	$response = $this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/settings');
	$response->assertRedirect('/en/settings/password');
});

describe('Redirect to /{locale}/login for guests', function (): void {
	test('should redirect when accessing "/" and the user', function (): void {
		$this->get('/')->assertRedirect('/en/login');
	});

	test('should redirect when accessing "/en"', function (): void {
		$this->get('/en')->assertRedirect('/en/login');
	});

	test('should redirect when accessing "/en/account"', function (): void {
		$this->get('/en/account')->assertRedirect('/en/login');
	});
});

describe('Redirect to /{locale}/account/entities for users', function (): void {
	test('should be redirected when accessing "/"', function (): void {
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/')->assertRedirect('/en/account/entities');
	});

	test('should be redirected when accessing "/en"', function (): void {
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en')->assertRedirect('/en/account/entities');
	});

	test('should be redirected when accessing "/en/login"', function (): void {
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/login')->assertRedirect('/en/account');
	});
});

test('should redirect to "/<route>" when accessing "/<route>/"', function (): void {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});

test('should redirect to "/<route>" when accessing "///<route>///"', function (): void {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});
