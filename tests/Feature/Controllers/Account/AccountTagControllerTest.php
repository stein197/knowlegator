<?php
namespace Tests\Feature\Controllers\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('/en/account/tags/create', function (): void {
	it('should redirect to /en/route for guests', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account/tags/create')->assertRedirect('/en/login');
	});

	it('should show form', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$content = $this->actingAs($u)->get('/en/account/tags/create')->getContent();
		$dom = $this->dom($content);
		$dom->assertExists('//form//input[@name="name"]');
		$dom->assertExists('//form//button');
	});
});
