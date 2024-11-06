<?php
namespace Tests\Feature\Controllers\Resource;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('entities.index (GET /{locale}/account/entities)', function (): void {
	test('should redirect guests to /{locale}/login', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account/entities')->assertRedirect('/en/login');
	});

	test('should show page for a user', function () {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$this->actingAs($user)->get('/en/account/entities')->assertOk();
	});
});
