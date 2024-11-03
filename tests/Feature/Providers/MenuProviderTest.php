<?php
namespace Tests\Feature\Model;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('should mark menu item as active when the request is deeper than the menu route', function (): void {
	/** @var \Tests\TestCase $this */
	$u = User::factory()->create();
	$content = $this->actingAs($u)->get('/en/account/tags/create')->getContent();
	$dom = $this->dom($content);
	$dom->find('//aside//a[contains(@class, "list-group-item") and contains(@class, "active")]')->assertTextContent('Tags');
});