<?php
namespace Tests\Feature\Http\Controllers\Resource;

use App\Models\User;

describe('entities.index (GET /{locale}/account/entities)', function (): void {
	test('should redirect guests to /{locale}/login', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account/entities')->assertRedirect('/en/login');
	});

	test('should show page for a user', function () {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/entities')->assertOk();
	});
});
