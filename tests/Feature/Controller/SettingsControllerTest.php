<?php
namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

it('should redirect to "/en/login" when the user is not authenticated', function (): void {
	/** @var \Tests\TestCase $this */
	$this->get('/en/settings')->assertRedirect('/en/login');
});

it('should show settings page', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$response = $this->actingAs($user)->get('/en/settings');
	$this->assertStringContainsString("<h1>Settings</h1>", $response->getContent());
});

it('should have a link to delete page', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$response = $this->actingAs($user)->get('/en/settings');
	$this->assertStringContainsString("href=\"/en/settings/delete\"", $response->getContent());
});
