<?php
namespace Tests\Feature\Controllers\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('GET /{locale}/account/tags/create', function (): void {
	it('should redirect to /{locale}/route for guests', function (): void {
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

describe('POST /{locale}/account/tags/create', function (): void {

	it('should show a success message when the tag is created', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$content = $this->actingAs($u)->post('/en/account/tags/create', ['name' => 'Tag'])->getContent();
		$dom = $this->dom($content);
		$dom->find('//p[contains(@class, "alert")]')->assertTextContent(__('message.tag.created', ['tag' => 'Tag']));
	});

	it('should show an error when the name is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$this->actingAs($u)->post('/en/account/tags/create', [])->assertSessionHasErrors(['name']);
	});

	it('should show an error when the name is invalid', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$this->actingAs($u)->post('/en/account/tags/create', [])->assertSessionHasErrors(['name']);
	});

	it('should show an error when the tag already exists', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$this->actingAs($u)->post('/en/account/tags/create', [])->assertSessionHasErrors(['name']);
	});
});
