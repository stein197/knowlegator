<?php
namespace Tests\Feature\Http\Controllers\Settings;

use App\Models\User;
use function json_decode;

describe('GET /{locale}/settings/export', function (): void {
	test('should redirect guests to /{locale}/login', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/settings/export')->assertRedirect('/en/login');
	});

	test('should render for users', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom($this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/settings/export')->getContent());
		$dom->assertExists('//section//a[@href = "/en/settings/export?download"]');
	});
});

test('GET /{locale}/settings/export?download', function (): void {
	/** @var \Tests\TestCase $this */
	$u = User::findByEmail('user-1@example.com');
	$response = $this->actingAs($u)->get('/en/settings/export?download');
	$response->assertHeader('Content-Type', 'application/json');
	$response->assertHeader('Content-Disposition', 'attachment; filename = "Knowlegator.json"');
	$json = json_decode($response->getContent(), true);
	$this->assertArrayContains($json, [
		'tag' => [
			['id' => $u->tags[0]->id, 'name' => 'tag-1'],
			['id' => $u->tags[1]->id, 'name' => 'tag-2']
		],
		'etype' => [
			['id' => $u->etypes[0]->id, 'name' => 'Etype 1'],
			['id' => $u->etypes[1]->id, 'name' => 'Etype 2', 'description' => 'Etype 2 description']
		]
	]);
	$this->assertCount(2, $json);
	$this->assertCount(2, $json['tag']);
	$this->assertCount(2, $json['etype']);
	$this->assertNull(@$json['tag'][0]['user_id']);
	$this->assertNull(@$json['tag'][1]['user_id']);
	$this->assertNull(@$json['etype'][0]['user_id']);
	$this->assertNull(@$json['etype'][1]['user_id']);
});
