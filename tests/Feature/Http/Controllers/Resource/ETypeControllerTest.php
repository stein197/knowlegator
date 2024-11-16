<?php
namespace Tests\Feature\Http\Controllers\Resource;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('etypes.index (GET /{locale}/account/etypes)', function (): void {
	test('should redirect guests to /{locale}/login', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account/etypes')->assertRedirect('/en/login');
	});

	// TODO: Update when the page is being updated
	test('should show page for users', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/etypes')->assertOk();
	});
});
