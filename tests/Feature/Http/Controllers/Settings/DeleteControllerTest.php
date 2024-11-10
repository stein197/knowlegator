<?php
namespace Tests\Feature\Http\Controllers\Settings;

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
		$content = $this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/settings/delete')->getContent();
		$dom = $this->dom($content);
		$dom->find('//h1')->assertTextContent('Delete account');
		$dom->assertExists('//form[@action="/en/settings/delete"]');
	});
});

describe('DELETE /{locale}/settings/delete', function (): void {
	test('should delete the current user and redirect to "/{locale}/login"', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$this->actingAs($u);
		$this->assertAuthenticated();
		$this->assertTrue($u->exists);
		$response = $this->delete('/en/settings/delete');
		$this->assertFalse($u->exists);
		$this->assertGuest();
		$response->assertRedirect('/en/login');
	});
});
