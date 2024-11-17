<?php
namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('*.show (GET /{locale}/account/*)', function (): void {
	test('should show attributes table', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->tags[0];
		$dom = $this->dom($this->actingAs($u)->get("/en/account/tags/{$t->id}")->getContent());
		$table = $dom->find('//section//table[@class = "table"]');
		$table->find('//tr/td')->assertTextContent('name');
		$table->find('//tr/td')->assertTextContent('tag-1');
	});
});
