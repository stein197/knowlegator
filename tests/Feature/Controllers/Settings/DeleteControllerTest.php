<?php
namespace Tests\Feature\Controller\Settings;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('GET /{locale}/settings/delete', function (): void {
	test('should redirect to "/{locale}/login" for guests', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/settings/delete')->assertRedirect('/en/login');
	});

	test('should show page for users', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$content = $this->actingAs($user)->get('/en/settings/delete')->getContent();
		$dom = $this->dom($content);
		$dom->find('//h1')->assertTextContent('Delete account');
		$dom->assertExists('//form[@action="/en/settings/delete"]');
	});
});

describe('DELETE /{locale}/settings/delete', function (): void {
	test('should delete the current user and redirect to "/{locale}/login"', function (): void {
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
});
