<?php
namespace Tests\Feature\Controllers\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

// TODO: Place in EntityControllerTest
test('GET /{locale}/account/entities should redirect to /{locale}/login for a guest', function (): void {
	/** @var \Tests\TestCase $this */
	$this->get('/en/account/entities')->assertRedirect('/en/login');
});

test('GET /{locale}/account/entities should show page for a user', function () {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user)->get('/en/account/entities')->assertOk();
});
