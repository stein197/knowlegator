<?php
namespace Tests\Feature\Http\Controllers\Resource;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('etypes.index (GET /{locale}/account/etypes)', function (): void {
	test('should redirect to /{locale}/login for a guest', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/account/etypes')->assertRedirect('/en/login');
	});

	test('should show page for a user', function () {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/etypes')->assertOk();
	});

	test('should show message when there are no etypes', function (): void {
		/** @var \Tests\TestCase $this */
		$content = $this->actingAs(User::findByEmail('user-3@example.com'))->get('/en/account/etypes')->getContent();
		$dom = $this->dom($content);
		$dom->find('//section//p[contains(@class, "alert")]/span')->assertTextContent(__('resource.etype.index.message.empty'));
	});

	test('should show list of etypes without message when there are etypes', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$content = $this->actingAs($u)->get('/en/account/etypes')->getContent();
		$dom = $this->dom($content);
		$dom->assertNotExists('//section//p[contains(@class, "alert")]');
		$badges = $dom->find('//section//a[contains(@class, "list-group-item")]');
		$badges->assertTextContent('Etype 1');
		$badges->assertTextContent('Etype 2');
		$badges->assertLinkExists('/en/account/etypes/' . $u->etypes[0]->id);
		$badges->assertLinkExists('/en/account/etypes/' . $u->etypes[1]->id);
	});

	test('should show link to create page', function (): void {
		/** @var \Tests\TestCase $this */
		$content = $this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/etypes')->getContent();
		$dom = $this->dom($content);
		$dom->assertExists('//a[@href="/en/account/etypes/create"]');
	});

	describe('search', function (): void {
		test('should not render the search bar when there are no etypes', function (): void {
			/** @var \Tests\TestCase $this */
			$dom = $this->dom($this->actingAs(User::findByEmail('user-3@example.com'))->get('/en/account/etypes')->getContent());
			$dom->assertNotExists('//form[@action = "/en/account/etypes"]//button/i[contains(@class, "bi-search")]');
		});

		test('should render the search bar when there are etypes', function (): void {
			/** @var \Tests\TestCase $this */
			$dom = $this->dom($this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/etypes')->getContent());
			$dom->assertExists('//form[@action = "/en/account/etypes" and @method = "GET"]//input[@name = "q"]');
		});

		test('should render the search bar where there are etypes and the search query', function (): void {
			/** @var \Tests\TestCase $this */
			$dom = $this->dom($this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/etypes?q=etype')->getContent());
			$dom->assertExists('//form[@action = "/en/account/etypes" and @method = "GET"]//input[@name = "q"]');
		});

		test('should render all etypes when the query is empty', function (): void {
			/** @var \Tests\TestCase $this */
			$u = User::findByEmail('user-1@example.com');
			$dom = $this->dom($this->actingAs($u)->get('/en/account/etypes?q=')->getContent());
			$dom->assertLinkExists("/en/account/etypes/{$u->etypes[0]->id}");
			$dom->assertLinkExists("/en/account/etypes/{$u->etypes[1]->id}");
		});

		test('should render only matching etypes when the query is not empty', function (): void {
			/** @var \Tests\TestCase $this */
			$u = User::findByEmail('user-1@example.com');
			$dom = $this->dom($this->actingAs($u)->get('/en/account/etypes?q=e 1')->getContent());
			$dom->assertExists("//a[@href = \"/en/account/etypes/{$u->etypes[0]->id}\"]");
			$dom->assertNotExists("//a[@href = \"/en/account/etypes/{$u->etypes[1]->id}\"]");
		});

		test('should render only matching etypes when the query is not empty and the case doesn\'t match', function (): void {
			/** @var \Tests\TestCase $this */
			$u = User::findByEmail('user-1@example.com');
			$dom = $this->dom($this->actingAs($u)->get('/en/account/etypes?q=E 1')->getContent());
			$dom->assertExists("//a[@href = \"/en/account/etypes/{$u->etypes[0]->id}\"]");
			$dom->assertNotExists("//a[@href = \"/en/account/etypes/{$u->etypes[1]->id}\"]");
		});

		test('should render an empty result message when no etypes match the given query', function (): void {
			/** @var \Tests\TestCase $this */
			$u = User::findByEmail('user-1@example.com');
			$dom = $this->dom($this->actingAs($u)->get('/en/account/etypes?q=unknown')->getContent());
			$dom->find('//p[contains(@class, "alert-info")]/span')->assertTextContent('No entity types matching the query');
			$dom->assertNotExists("//a[@href = \"/en/account/etypes/{$u->etypes[0]->id}\"]");
			$dom->assertNotExists("//a[@href = \"/en/account/etypes/{$u->etypes[1]->id}\"]");
		});

		test('should render all etypes and the search bar when the query is an array', function (): void {
			/** @var \Tests\TestCase $this */
			$u = User::findByEmail('user-1@example.com');
			$dom = $this->dom($this->actingAs($u)->get('/en/account/etypes?q[]=query')->getContent());
			$dom->assertExists('//form[@action = "/en/account/etypes" and @method = "GET"]//input[@name = "q"]');
			$dom->assertLinkExists("/en/account/etypes/{$u->etypes[0]->id}");
			$dom->assertLinkExists("/en/account/etypes/{$u->etypes[1]->id}");
		});
	});
});

describe('etypes.show (GET /{locale}/account/etypes/{etype})', function (): void {
	test('should show for a user', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$content = $this->actingAs($u)->get('/en/account/etypes/' . $u->etypes[0]->id)->getContent();
		$dom = $this->dom($content);
		$dom->find('//h1')->assertTextContent('Entity Types / Etype 1');
	});

	test('should return 404 when the etype does not exist', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/etypes/' . fake()->uuid())->assertNotFound();
	});

	test('should return 404 when accessing a etype for another user', function (): void {
		/** @var \Tests\TestCase $this */
		$this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/account/etypes/' . User::findByEmail('user-2@example.com')->etypes[0]->id)->assertNotFound();
	});

	test('should be available to deletion', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$etype = $u->etypes[0];
		$content = $this->actingAs($u)->get("/en/account/etypes/{$etype->id}?action=delete")->getContent();
		$dom = $this->dom($content);
		$dom->find('//h1')->assertTextContent('Entity Types / Delete / Etype 1');
		$dom->assertExists('//form/input[@name = "_method" and @value = "DELETE"]');
		$dom->assertExists('//form//button');
	});
});
