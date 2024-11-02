<?php
namespace Tests\Feature\Controllers\Account;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('/en/account/tags should redirect to /en/login for a guest', function (): void {
	/** @var \Tests\TestCase $this */
	$this->get('/en/account/tags')->assertRedirect('/en/login');
});

test('/en/account/tags should show page for a user', function () {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user)->get('/en/account/tags')->assertOk();
});

test('should show message when there are no tags', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$content = $this->actingAs($user)->get('/en/account/tags')->getContent();
	$dom = $this->dom($content);
	$dom->find('//section//p[contains(@class, "alert")]')->assertTextContent(__('page.account.tag-list.empty'));
});

test('should show list of tags without message when there are tags', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$t1 = Tag::factory()->create(['name' => 'tag-1', 'user_id' => $user->id]);
	$t2 = Tag::factory()->create(['name' => 'tag-2', 'user_id' => $user->id]);
	$content = $this->actingAs($user)->get('/en/account/tags')->getContent();
	$dom = $this->dom($content);
	$dom->assertNotExists('//section//p[contains(@class, "alert")]');
	$badges = $dom->find('//section//a[contains(@class, "badge")]');
	$badges->assertTextContent($t1->name);
	$badges->assertTextContent($t2->name);
});
