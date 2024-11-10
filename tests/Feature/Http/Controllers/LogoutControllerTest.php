<?php
namespace Tests\Feature\Http\Controllers;

use App\Models\User;

describe('POST /{locale}/logout', function (): void {
	test('should redirect to /{locale}/login for guests', function (): void {
		/** @var \Tests\TestCase $this */
		$this->post('/en/logout')->assertRedirect('/en/login');
	});

	test('should unauthenticate user for users', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->post('/en/logout')->assertRedirect('/en/login');
		$this->assertGuest();
	});
});
