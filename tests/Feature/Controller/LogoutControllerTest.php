<?php
namespace Tests\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

it('should not access the route when the user is unauthenticated', function (): void {
	/** @var \Tests\TestCase $this */
	$this->post('/en/logout')->assertRedirect('/en/login');
});

it('should unauthenticate user at when the user is authenticated', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user)->post('/en/logout')->assertRedirect('/en/login');
	$this->assertGuest();
});

it('should not exist for GET request', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user)->get('/en/logout')->assertStatus(405);
});
