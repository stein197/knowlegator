<?php
namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('/en/account should redirect to /en/login for a guest', function (): void {
	/** @var \Tests\TestCase $this */
	$this->get('/en/account')->assertRedirect('/en/login');
});

test('/en/account should redirect to /en/account/entities for a user', function () {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user);
	$this->get('/en/account')->assertRedirect('/en/account/entities');
});
