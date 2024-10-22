<?php
namespace Tests\Feature\Controller\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

it('should redirect to "/en/login" when the user is unauthenticated', function (): void {
	/** @var \Tests\TestCase $this */
	$this->get('/en/settings/password')->assertRedirect('/en/login');
});

it('should show the page', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$response = $this->actingAs($user)->get('/en/settings/password');
	$this->assertStringContainsString('action="/en/settings/password"', $response->getContent());
});

it('should show an error when the current password does not match with the input', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$response = $this->actingAs($user)->put('/en/settings/password', ['old' => '-', 'new' => '123', 'repeat' => '123']);
	$response->assertSessionHasErrors(['old']);
});

it('should show an error when the new password is empty', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create(['password' => '123']);
	$response = $this->actingAs($user)->put('/en/settings/password', ['old' => '123', 'new' => '', 'repeat' => '']);
	$response->assertSessionHasErrors(['new']);
});

it('should show an error when the new password does not match with the repeated one', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create(['password' => '123']);
	$response = $this->actingAs($user)->put('/en/settings/password', ['old' => '123', 'new' => '456', 'repeat' => '789']);
	$response->assertSessionHasErrors(['repeat']);
});

it('should change the password and be able to login with the new one', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create(['email' => 'new@user.com', 'password' => '123']);
	$this->actingAs($user)->put('/en/settings/password', ['old' => '123', 'new' => '456', 'repeat' => '456'])->assertOk();
	$this->post('/en/logout');
	$this->assertGuest();
	$this->post('/en/login', ['email' => 'new@user.com', 'password' => '456', 'action' => 'login']);
	$this->assertAuthenticated();
});
