<?php
namespace Tests\Feature\Services;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('GET /en/settings/password', function (): void {
	/** @var \Tests\TestCase $this */
	$u = User::factory()->create();
	$content = $this->actingAs($u)->get('/en/settings/password')->getContent();
	$dom = $this->dom($content);
	$dom->find('//ol[@class="breadcrumb"]/li[position() = 1]')->assertTextContent('Settings');
	$dom->find('//ol[@class="breadcrumb"]/li[position() = 2]')->assertTextContent('Change password');
});

test('GET /en/account/tags', function (): void {
	/** @var \Tests\TestCase $this */
	$u = User::factory()->create();
	$content = $this->actingAs($u)->get('/en/account/tags')->getContent();
	$dom = $this->dom($content);
	$dom->find('//ol[@class="breadcrumb"]/li[position() = 1]')->assertTextContent('Account');
	$dom->find('//ol[@class="breadcrumb"]/li[position() = 2]/a')->assertTextContent('Tags');
});

test('GET /en/account/tags/create', function (): void {
	/** @var \Tests\TestCase $this */
	$u = User::factory()->create();
	$content = $this->actingAs($u)->get('/en/account/tags/create')->getContent();
	$dom = $this->dom($content);
	$dom->find('//ol[@class="breadcrumb"]/li[position() = 1]')->assertTextContent('Account');
	$dom->find('//ol[@class="breadcrumb"]/li[position() = 2]/a')->assertTextContent('Tags');
	$dom->assertExists('//ol[@class="breadcrumb"]/li[position() = 2]/a[@href = "/en/account/tags"]');
	$dom->find('//ol[@class="breadcrumb"]/li[position() = 3]')->assertTextContent('New tag');
});
