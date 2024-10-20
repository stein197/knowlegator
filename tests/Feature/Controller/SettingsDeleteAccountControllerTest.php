<?php
namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

it('should redirect to "/en/login" when the user is not authenticated', function (): void {
	/** @var \Tests\TestCase $this */
	$this->get('/en/settings/delete')->assertRedirect('/en/login');
});

it('should show deletion page', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$response = $this->actingAs($user)->get('/en/settings/delete');
	$this->assertStringContainsString("<h1>Delete account</h1>", $response->getContent());
	$this->assertStringContainsString("action=\"/en/settings/delete", $response->getContent());
});

it('should delete the current user and redirect to "/en/login"', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user);
	$this->assertAuthenticated();
	$this->assertTrue($user->exists);
	$response = $this->delete('/en/settings/delete');
	$this->assertFalse($user->exists);
	$this->assertGuest();
	$response->assertRedirect('/en/login');
});
