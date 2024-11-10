<?php
namespace Tests\Feature\Http\Controllers\Resource;

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
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/tags')->assertOk();
	});

	test('should show message when there are no tags', function (): void {
		/** @var \Tests\TestCase $this */
		$content = $this->actingAs(User::findByEmail('user-3@example.com'))->get('/en/account/tags')->getContent();
		$dom = $this->dom($content);
		$dom->find('//section//p[contains(@class, "alert")]')->assertTextContent(__('resource.tag.index.message.empty'));
	});

	test('should show list of tags without message when there are tags', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$content = $this->actingAs($u)->get('/en/account/tags')->getContent();
		$dom = $this->dom($content);
		$dom->assertNotExists('//section//p[contains(@class, "alert")]');
		$badges = $dom->find('//section//a[contains(@class, "badge")]');
		$badges->assertTextContent('tag-1');
		$badges->assertTextContent('tag-2');
		$badges->assertLinkExists('/en/account/tags/' . $u->findTagByName('tag-1')->id);
		$badges->assertLinkExists('/en/account/tags/' . $u->findTagByName('tag-2')->id);
	});

	test('should show link to create page', function (): void {
		/** @var \Tests\TestCase $this */
		$content = $this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/tags')->getContent();
		$dom = $this->dom($content);
		$dom->assertExists('//a[@href="/en/account/tags/create"]');
	});
});

describe('tags.create (GET /{locale}/account/tags/create)', function (): void {
	test('should redirect guests to /{locale}/route', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account/tags/create')->assertRedirect('/en/login');
	});

	test('should show for users', function (): void {
		/** @var \Tests\TestCase $this */
		$content = $this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/tags/create')->getContent();
		$dom = $this->dom($content);
		$dom->assertExists('//form[@action = "/en/account/tags"]');
		$dom->assertExists('//form//input[@name="name"]');
		$dom->assertExists('//form//button');
	});
});

describe('tags.store (POST /{locale}/account/tags)', function (): void {
	test('should show a success message when the tag is created', function (): void {
		/** @var \Tests\TestCase $this */
		$content = $this->actingAs(User::findByEmail('user-1@example.com'))->post('/en/account/tags', ['name' => 'Tag'])->getContent();
		$dom = $this->dom($content);
		$dom->find('//p[contains(@class, "alert")]')->assertTextContent(__('message.tag.created', ['tag' => 'Tag']));
	});

	test('should show an error when the name is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->post('/en/account/tags', [])->assertSessionHasErrors(['name']);
	});

	test('should show an error when the name is invalid', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->post('/en/account/tags', [])->assertSessionHasErrors(['name']);
	});

	test('should show an error when the tag already exists', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->post('/en/account/tags', [])->assertSessionHasErrors(['name']);
	});
});

describe('tags.show (GET /{locale}/account/tags/{tag})', function (): void {
	test('should show for a user', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$content = $this->actingAs($u)->get('/en/account/tags/' . $u->findTagByName('tag-1')->id)->getContent();
		$dom = $this->dom($content);
		$dom->find('//h1')->assertTextContent('Tag: tag-1');
	});

	test('should return 404 when the tag does not exist', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/tags/' . fake()->uuid())->assertNotFound();
	});

	test('should return 404 when accessing a tag for another user', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/tags/' . User::findByEmail('user-2@example.com')->findTagByName('tag-3')->id)->assertNotFound();
	});

	test('should be available to deletion', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$content = $this->actingAs($u)->get("/en/account/tags/{$u->findTagByName('tag-1')->id}?action=delete")->getContent();
		$dom = $this->dom($content);
		$dom->find('//h1')->assertTextContent('Delete tag');
		$dom->assertExists('//form/input[@name = "_method" and @value = "DELETE"]');
		$dom->assertExists('//form//button');
	});
});

describe('tags.edit (GET /{locale}/account/tags/{tag}/edit)', function (): void {
	test('should show 404 when tag does not exist', function (): void  {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/tags/' . fake()->uuid())->assertNotFound();
	});

	test('should show 404 when tag exists but belongs to another user', function (): void  {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/tags/' . User::findByEmail('user-2@example.com')->findTagByName('tag-3')->id . '/edit')->assertNotFound();
	});

	test('should show edit page', function (): void  {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->findTagByName('tag-1');
		$content = $this->actingAs($u)->get("/en/account/tags/{$t->id}/edit")->getContent();
		$dom = $this->dom($content);
		$form = $dom->find("//form[@action = \"/en/account/tags/{$t->id}\"]");
		$form->assertExists('//input[@name = "_method" and @value="PUT"]');
		$form->assertExists('//input[@name = "name"]');
		$form->find("//a[@href = \"/en/account/tags/{$t->id}\"]")->assertTextContent('Cancel');
		$form->find('//button')->assertTextContent('Save');
	});
});

describe('tags.update (PUT /{locale}/account/tag/{tag})', function (): void {
	test('should show an error when the name is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->findTagByName('tag-1');
		$this->actingAs($u)->put("/en/account/tags/{$t->id}", ['name' => ''])->assertSessionHasErrors(['name']);
	});

	test('should show an error when a tag with the given name already exists', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->findTagByName('tag-1');
		$this->actingAs($u)->put("/en/account/tags/{$t->id}", ['name' => 'tag-2'])->assertSessionHasErrors(['name']);
	});

	test('should save', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->findTagByName('tag-1');
		$content = $this->actingAs($u)->put("/en/account/tags/{$t->id}", ['name' => 'tag-3'])->getContent();
		$dom = $this->dom($content);
		$dom->find('//p[contains(@class, "alert-success")]/span')->assertTextContent('Tag "tag-3" has been successfully updated');
	});
});

describe('tags.destroy (DELETE /{locale}/account/tags/{tag})', function (): void {
	test('should delete a tag', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->findTagByName('tag-1');
		$content = $this->actingAs($u)->delete("/en/account/tags/{$t->id}")->getContent();
		$this->dom($content)->find('//p[contains(@class, "alert-success")]')->assertTextContent(__('message.tag.deleted', ['tag' => $t->name]));
		$this->assertFalse(auth()->user()->findTagById($t->id)->exists);
	});
});
