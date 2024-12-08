<?php
namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\ImportExportService;
use function json_decode;

// TODO
describe('import()', function (): void {

});

test('export()', function (): void {
	/** @var \Tests\TestCase $this */
	$u = User::findByEmail('user-1@example.com');
	$ieService = $this->createApplication()->makeWith(ImportExportService::class, ['user' => $u]);
	$actual = json_decode($ieService->export(), true);
	$this->assertArrayContains($actual, [
		'tag' => [
			['id' => $u->tags[0]->id, 'name' => 'tag-1'],
			['id' => $u->tags[1]->id, 'name' => 'tag-2']
		],
		'etype' => [
			['id' => $u->etypes[0]->id, 'name' => 'Etype 1'],
			['id' => $u->etypes[1]->id, 'name' => 'Etype 2', 'description' => 'Etype 2 description']
		]
	]);
	$this->assertCount(2, $actual);
	$this->assertCount(2, $actual['tag']);
	$this->assertCount(2, $actual['etype']);
	$this->assertNull(@$actual['tag'][0]['user_id']);
	$this->assertNull(@$actual['tag'][1]['user_id']);
	$this->assertNull(@$actual['etype'][0]['user_id']);
	$this->assertNull(@$actual['etype'][1]['user_id']);
});
