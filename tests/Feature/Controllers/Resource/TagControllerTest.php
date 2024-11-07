<?php
namespace Tests\Feature\Controllers\Resource;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('tags.index (GET /{locale}/account/tags)', function (): void {
	test('should redirect to /{locale}/login for a guest', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account/tags')->assertRedirect('/en/login');
	});

	test('should show page for a user', function () {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$this->actingAs($user)->get('/en/account/tags')->assertOk();
	});

	test('should show message when there are no tags', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$content = $this->actingAs($user)->get('/en/account/tags')->getContent();
		$dom = $this->dom($content);
		$dom->find('//section//p[contains(@class, "alert")]')->assertTextContent(__('resource.tag.index.message.empty'));
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
		$badges->assertLinkExists("/en/account/tags/{$t1->id}");
		$badges->assertLinkExists("/en/account/tags/{$t2->id}");
	});

	test('should show link to create page', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$content = $this->actingAs($user)->get('/en/account/tags')->getContent();
		$dom = $this->dom($content);
		$dom->assertExists('//a[@href="/en/account/tags/create"]');
	});
});

describe('tags.create (GET /{locale}/account/tags/create)', function (): void {
	it('should redirect guests to /{locale}/route', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account/tags/create')->assertRedirect('/en/login');
	});

	it('should show for users', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$content = $this->actingAs($u)->get('/en/account/tags/create')->getContent();
		$dom = $this->dom($content);
		$dom->assertExists('//form//input[@name="name"]');
		$dom->assertExists('//form//button');
	});
});

describe('tags.store (POST /{locale}/account/tags)', function (): void {
	it('should show a success message when the tag is created', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$content = $this->actingAs($u)->post('/en/account/tags', ['name' => 'Tag'])->getContent();
		$dom = $this->dom($content);
		$dom->find('//p[contains(@class, "alert")]')->assertTextContent(__('message.tag.created', ['tag' => 'Tag']));
	});

	it('should show an error when the name is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$this->actingAs($u)->post('/en/account/tags', [])->assertSessionHasErrors(['name']);
	});

	it('should show an error when the name is invalid', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$this->actingAs($u)->post('/en/account/tags', [])->assertSessionHasErrors(['name']);
	});

	it('should show an error when the tag already exists', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$this->actingAs($u)->post('/en/account/tags', [])->assertSessionHasErrors(['name']);
	});
});

describe('tags.show (GET /{locale}/account/tags/{tag})', function (): void {
	test('should show for a user', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$t = Tag::factory()->create(['name' => 'Tag', 'user_id' => $u->id]);
		$content = $this->actingAs($u)->get("/en/account/tags/{$t->id}")->getContent();
		$dom = $this->dom($content);
		$dom->find('//h1')->assertTextContent('Tag: Tag');
	});

	test('should return 404 when the tag does not exist', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		$this->actingAs($u)->get('/en/account/tags/' . fake()->uuid())->assertNotFound();
	});

	test('should return 404 when accessing a tag for another user', function (): void {
		/** @var \Tests\TestCase $this */
		$u1 = User::factory()->create();
		$u2 = User::factory()->create();
		$t = Tag::factory()->create(['name' => 'Tag', 'user_id' => $u2->id]);
		$this->actingAs($u1)->get("/en/account/tags/{$t->id}")->assertNotFound();
	});
});
