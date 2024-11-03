<?php
namespace Tests\Feature\Model;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use function sizeof;
use function array_map;

uses(DatabaseTransactions::class);

describe('tags()', function (): void {
	test('should return empty collection when user does not have any tags', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$this->assertEmpty($user->tags);
	});

	test('should return only assigned collection of tags', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		[$t1, $t2, $t3] = Tag::factory()->createMany([
			['name' => 'Tag1', 'user_id' => $user->id],
			['name' => 'Tag2', 'user_id' => $user->id],
			['name' => 'Tag3', 'user_id' => $user->id],
		]);
		$this->assertSame(3, sizeof($user->tags));
		$ids = [$t1->id, $t2->id, $t3->id];
		$this->assertContains($user->tags[0]->id, $ids);
		$this->assertContains($user->tags[1]->id, $ids);
		$this->assertContains($user->tags[2]->id, $ids);
	});

	test('should not return tags for other users', function (): void {
		/** @var \Tests\TestCase $this */
		[$u1, $u2] = User::factory()->createMany(2);
		[$t1, $t2] = Tag::factory()->createMany([
			['name' => 'Tag1', 'user_id' => $u1->id],
			['name' => 'Tag2', 'user_id' => $u1->id],
		]);
		[$t3, $t4] = Tag::factory()->createMany([
			['name' => 'Tag1', 'user_id' => $u2->id],
			['name' => 'Tag2', 'user_id' => $u2->id],
		]);
		$u1Tags = array_map(fn (Tag $tag): string => $tag->id, [...$u1->tags]);
		$u2Tags = array_map(fn (Tag $tag): string => $tag->id, [...$u2->tags]);
		$this->assertContains($t1->id, $u1Tags);
		$this->assertContains($t2->id, $u1Tags);
		$this->assertNotContains($t3->id, $u1Tags);
		$this->assertNotContains($t4->id, $u1Tags);
		$this->assertNotContains($t1->id, $u2Tags);
		$this->assertNotContains($t2->id, $u2Tags);
		$this->assertContains($t3->id, $u2Tags);
		$this->assertContains($t4->id, $u2Tags);
	});
});
