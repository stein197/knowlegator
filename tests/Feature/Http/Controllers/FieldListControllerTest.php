<?php
namespace Tests\Feature\Http\Controllers;

use App\Models\User;

describe('GET /{locale}/account/fields', function (): void {
	test('should redirect guests to /{locale}/login', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account/fields')->assertRedirect('/en/login');
	});

	test('should show for a user', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/fields')->assertOk();
	});
});
