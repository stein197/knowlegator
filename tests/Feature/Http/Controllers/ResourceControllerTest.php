<?php
namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('*.show (GET /{locale}/account/*/{id})', function (): void {
	test('should show readonly form', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$etype = $u->etypes[0];
		$dom = $this->dom($this->actingAs($u)->get("/en/account/etypes/{$etype->id}")->getContent());
		$form = $dom->find('//form[@action = "" and @method = "GET"]');
		$form->assertExists("//input[@name = \"name\" and @value = \"{$etype->name}\" and @readonly]");
		$form->assertExists("//textarea[@name = \"description\" and @value = \"{$etype->description}\" and @readonly]");
		$form->assertExists("//a[@href = \"/en/account/etypes\"]");
		$form->assertExists("//a[@href = \"/en/account/etypes/{$etype->id}/edit\"]");
		$form->assertExists("//a[@href = \"/en/account/etypes/{$etype->id}/delete\"]");
	});
});

describe('*.delete (GET /{locale}/account/*/{id}/delete)', function (): void {
	test('should have cancel button', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->tags[0];
		$dom = $this->dom($this->actingAs($u)->get("/en/account/tags/{$t->id}/delete")->getContent());
		$dom->assertExists("//form//a[@href = \"/en/account/tags/{$t->id}\"]");
	});
});
