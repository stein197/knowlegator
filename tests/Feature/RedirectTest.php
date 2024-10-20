<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('Unauthenticated used should be redirected to "/en/login"', function (): void {
	it('should redirect when accessing "/" and the user', function (): void {
		$this->get('/')->assertRedirect('/en/login');
	});
	
	it('should redirect when accessing "/en"', function (): void {
		$this->get('/en')->assertRedirect('/en/login');
	});

	it('should redirect when accessing "/en/account"', function (): void {
		$this->get('/en/account')->assertRedirect('/en/login');
	});
});

describe('Authenticated used should be redirected to "/en/account"', function (): void {
	it('should be redirected when accessing "/"', function (): void {
		$user = User::factory()->create();
		$this->actingAs($user)->get('/')->assertRedirect('/en/account');
	});

	it('should be redirected when accessing "/en"', function (): void {
		$user = User::factory()->create();
		$this->actingAs($user)->get('/en')->assertRedirect('/en/account');
	});

	it('should be redirected when accessing "/en/login"', function (): void {
		$user = User::factory()->create();
		$this->actingAs($user)->get('/en/login')->assertRedirect('/en/account');
	});
});

it('should redirect to "/<route>" when accessing "/<route>/"', function (): void {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});

it('should redirect to "/<route>" when accessing "///<route>///"', function (): void {
	$this->markTestSkipped('$response always has no trailing slashes and returns 200');
});
