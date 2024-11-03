<?php
namespace Tests\Feature\Controller;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('GET /{locale}/settings', function (): void {	
	test('should redirect to the first submenu for users', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$response = $this->actingAs($user)->get('/en/settings');
		$response->assertRedirect('/en/settings/password');
	});
});
