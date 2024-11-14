<?php
namespace Tests\Feature\Models;

use App\Models\EType;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('user', function (): void {
	test('can get, set and save User object', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$etype = new EType(['name' => 'EType']);
		$etype->user = $u;
		$etype->save();
		$this->assertEquals($u, $etype->user);
		$this->assertEquals($u->id, $etype->user_id);
	});
});

describe('__construct()', function (): void {
	test('can save \'user\' property', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$etype = new EType(['name' => 'EType', 'user' => $u]);
		$etype->save();
		$this->assertEquals($u, $etype->user);
		$this->assertEquals($u->id, $etype->user_id);
	});
});
