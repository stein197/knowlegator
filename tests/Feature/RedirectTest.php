<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('GET /{locale}/account should redirect to /{locale}/account/entities', function () {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user);
	$this->get('/en/account')->assertRedirect('/en/account/entities');
});

test('GET /{locale}/settings should redirect to /{locale}/settings/password', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$response = $this->actingAs($user)->get('/en/settings');
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
		$user = User::factory()->create();
		$this->actingAs($user)->get('/')->assertRedirect('/en/account/entities');
	});

	test('should be redirected when accessing "/en"', function (): void {
		$user = User::factory()->create();
		$this->actingAs($user)->get('/en')->assertRedirect('/en/account/entities');
	});

	test('should be redirected when accessing "/en/login"', function (): void {
		$user = User::factory()->create();
		$this->actingAs($user)->get('/en/login')->assertRedirect('/en/account');
	});
});

test('should redirect to "/<route>" when accessing "/<route>/"', function (): void {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});

test('should redirect to "/<route>" when accessing "///<route>///"', function (): void {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});
