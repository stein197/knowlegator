<?php
namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\ImportExportService;
use function json_decode;
use function sizeof;

// TODO
describe('import()', function (): void {

});

test('export()', function (): void {
	/** @var \Tests\TestCase $this */
	$u = User::findByEmail('user-1@example.com');
	$ieService = $this->createApplication()->makeWith(ImportExportService::class, ['user' => $u]);
	$actual = json_decode($ieService->export(), true);
	$this->assertSame(2, sizeof($actual));
	$this->assertSame(2, sizeof($actual['tag']));
	$this->assertSame($u->tags[0]->id, $actual['tag'][0]['id']);
	$this->assertSame($u->tags[0]->name, $actual['tag'][0]['name']);
	$this->assertNull(@$actual['tag'][0]['user_id']);
	$this->assertSame($u->tags[1]->id, $actual['tag'][1]['id']);
	$this->assertSame($u->tags[1]->name, $actual['tag'][1]['name']);
	$this->assertNull(@$actual['tag'][1]['user_id']);

	$this->assertSame(2, sizeof($actual['etype']));
	$this->assertSame($u->etypes[0]->id, $actual['etype'][0]['id']);
	$this->assertSame($u->etypes[0]->name, $actual['etype'][0]['name']);
	$this->assertNull(@$actual['etype'][0]['user_id']);
	$this->assertSame($u->etypes[1]->id, $actual['etype'][1]['id']);
	$this->assertSame($u->etypes[1]->name, $actual['etype'][1]['name']);
	$this->assertSame($u->etypes[1]->description, $actual['etype'][1]['description']);
	$this->assertNull(@$actual['etype'][1]['user_id']);
});
