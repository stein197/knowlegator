<?php
namespace Tests\Feature\Models;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use function sizeof;
use function array_map;

uses(DatabaseTransactions::class);

describe('tags()', function (): void {
	test('should return empty collection when user does not have any tags', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertEmpty(User::findByEmail('user-3@example.com')->tags);
	});

	test('should return only assigned collection of tags', function (): void {
		/** @var \Tests\TestCase $this */
		$u1 = User::findByEmail('user-1@example.com');
		$u2 = User::findByEmail('user-2@example.com');
		$tagNames1 = array_map(fn (Tag $t): string => $t->name, [...$u1->tags]);
		$tagNames2 = array_map(fn (Tag $t): string => $t->name, [...$u2->tags]);
		$this->assertSame(2, sizeof($tagNames1));
		$this->assertSame(2, sizeof($tagNames2));
		$this->assertContains('tag-1', $tagNames1);
		$this->assertContains('tag-2', $tagNames1);
		$this->assertContains('tag-3', $tagNames2);
		$this->assertContains('tag-4', $tagNames2);
	});

	test('should not return tags for other users', function (): void {
		/** @var \Tests\TestCase $this */
		$u1 = User::findByEmail('user-1@example.com');
		$u2 = User::findByEmail('user-2@example.com');
		$tagNames1 = array_map(fn (Tag $t): string => $t->name, [...$u1->tags]);
		$tagNames2 = array_map(fn (Tag $t): string => $t->name, [...$u2->tags]);
		$this->assertSame(2, sizeof($tagNames1));
		$this->assertSame(2, sizeof($tagNames2));
		$this->assertNotContains('tag-3', $tagNames1);
		$this->assertNotContains('tag-4', $tagNames1);
		$this->assertNotContains('tag-1', $tagNames2);
		$this->assertNotContains('tag-2', $tagNames2);
	});
});

describe('findTagById()', function (): void {
	test('should return corresponding tag when it exists', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->findTagById($u->tags[0]->id);
		$this->assertNotNull($u->findTagById($t->id));
	});

	test('should return null when tag does not exist', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertNull(User::findByEmail('user-1@example.com')->findTagById(fake()->uuid()));
	});

	test('should return null when accessing a tag for another user', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertNull(User::findByEmail('user-1@example.com')->findTagById(User::findByEmail('user-2@example.com')->tags[0]->id));
	});
});

describe('findTagByName()', function (): void {
	test('should return corresponding tag when it exists', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertNotNull(User::findByEmail('user-1@example.com')->findTagByName('tag-1'));
	});

	test('should return null when tag does not exist', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertNull(User::findByEmail('user-1@example.com')->findTagByName('tag-0'));
	});

	test('should return null when accessing a tag for another user', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertNull(User::findByEmail('user-1@example.com')->findTagByName('tag-3'));
	});
});

describe('static findByEmail()', function (): void {
	test('should return a user when it exist', function (): void {
		/** @var Tests\TestCase $this */
		$this->assertNotNull(User::findByEmail('user-1@example.com'));
	});
	test('should return null when it doesn\'t exist', function (): void {
		/** @var Tests\TestCase $this */
		$this->assertNull(User::findByEmail('user-unknown@example.com'));
	});
});
