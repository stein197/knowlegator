<?php
namespace Tests\Feature\Controllers\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('/en/account/entities should redirect to /en/login for a guest', function (): void {
	/** @var \Tests\TestCase $this */
	$this->get('/en/account/entities')->assertRedirect('/en/login');
});

test('/en/account/entities should show page for a user', function () {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user)->get('/en/account/entities')->assertOk();
});
