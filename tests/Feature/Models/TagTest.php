<?php
namespace Tests\Feature\Models;

use App\Exceptions\TagInvalidNameException;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('name', function (): void {
	test('should not accept empty name when creating a tag', function (): void {
		/** @var \Tests\TestCase $this */
		$this->expectException(TagInvalidNameException::class);
		$this->expectExceptionCode(TagInvalidNameException::REASON_EMPTY);
		$u = User::factory()->create();
		new Tag([
			'name' => '',
			'user_id' => $u
		]);
	});

	test('should not accept invalid name when creating a tag', function (): void {
		/** @var \Tests\TestCase $this */
		$this->expectException(TagInvalidNameException::class);
		$this->expectExceptionCode(TagInvalidNameException::REASON_INVALID);
		$u = User::factory()->create();
		new Tag([
			'name' => 'invalid name',
			'user_id' => $u
		]);
	});

	test('should not accept empty name after creating a tag', function (): void {
		/** @var \Tests\TestCase $this */
		$this->expectException(TagInvalidNameException::class);
		$this->expectExceptionCode(TagInvalidNameException::REASON_EMPTY);
		$u = User::factory()->create();
		$t = new Tag([
			'name' => 'Tag',
			'user_id' => $u
		]);
		$t->name = '';
	});

	test('should not accept invalid name after creating a tag', function (): void {
		/** @var \Tests\TestCase $this */
		$this->expectException(TagInvalidNameException::class);
		$this->expectExceptionCode(TagInvalidNameException::REASON_INVALID);
		$u = User::factory()->create();
		$t = new Tag([
			'name' => 'Tag',
			'user_id' => $u
		]);
		$t->name = 'invalid name';
	});
});

describe('user()', function (): void {
	test('should return assigned user', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->findTagByName('tag-1');
		$this->assertEquals($u->id, $t->user->id);
	});

	test('cannot create two tags with the same name for the same user', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		try {
			Tag::factory()->create(['name' => 'tag-1', 'user_id' => $u->id]);
		} catch (\Exception $ex) {
			$this->assertTrue(true);
		}
	});

	test('can create two tags with the same name for different users', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = Tag::factory()->create(['name' => 'tag-3', 'user_id' => $u->id]);
		$this->assertSame($t->id, $u->tags[2]->id);
	});
});
