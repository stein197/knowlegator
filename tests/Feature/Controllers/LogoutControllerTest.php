<?php
namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('POST /{locale}/logout', function (): void {
	test('should redirect to /{locale}/login for guests', function (): void {
		/** @var \Tests\TestCase $this */
		$this->post('/en/logout')->assertRedirect('/en/login');
	});
	
	test('should unauthenticate user for users', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$this->actingAs($user)->post('/en/logout')->assertRedirect('/en/login');
		$this->assertGuest();
	});
});
