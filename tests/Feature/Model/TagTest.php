<?php
namespace Tests\Feature\Model;

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
		$u = User::factory()->create();
		$t = Tag::factory()->create(['name' => 'Tag', 'user_id' => $u->id]);
		$this->assertEquals($u->id, $t->user->id);
	});

	test('cannot create two tags with the same name for the same user', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::factory()->create();
		Tag::factory()->create(['name' => 'Tag', 'user_id' => $u->id]);
		try {
			Tag::factory()->create(['name' => 'Tag', 'user_id' => $u->id]);
		} catch (\Exception $ex) {
			$this->assertTrue(true);
		}
	});

	test('can create two tags with the same name for different users', function (): void {
		/** @var \Tests\TestCase $this */
		[$u1, $u2] = User::factory()->createMany(2);
		[$t1, $t2] = Tag::factory()->createMany([
			['name' => 'Tag', 'user_id' => $u1->id],
			['name' => 'Tag', 'user_id' => $u2->id]
		]);
		$this->assertSame($u1->tags[0]->id, $t1->id);
		$this->assertSame($u2->tags[0]->id, $t2->id);
		$this->assertSame($t1->name, $t2->name);
	});
});
