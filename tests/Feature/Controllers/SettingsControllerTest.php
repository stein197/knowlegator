<?php
namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

it('should redirect to "/en/login" when the user is not authenticated', function (): void {
	/** @var \Tests\TestCase $this */
	$this->get('/en/settings')->assertRedirect('/en/login');
});

it('should redirect to the first submenu when the user is authenticated', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$response = $this->actingAs($user)->get('/en/settings');
	$response->assertRedirect('/en/settings/password');
});
