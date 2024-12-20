<?php
namespace Tests\Feature\Models;

use App\Models\EType;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use function sizeof;
use function array_map;

uses(DatabaseTransactions::class);

describe('tags', function (): void {
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

describe('etypes', function (): void {
	test('should return an empty collection when user doesn\'t have any etypes', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertEmpty(User::findByEmail('user-3@example.com')->etypes);
	});

	test('should return only assigned etypes', function (): void {
		/** @var \Tests\TestCase $this */
		$eTypeNames = array_map(fn (EType $etype): string => $etype->name, [...User::findByEmail('user-1@example.com')->etypes]);
		$this->assertSame(2, sizeof($eTypeNames));
		$this->assertContains('Etype 1', $eTypeNames);
		$this->assertContains('Etype 2', $eTypeNames);
	});
});

describe('createTag()', function (): void {
	test('should create a tag', function (): void {
		$u = User::findByEmail('user-1@example.com');
		$t = $u->createTag(['name' => 'tag-3']);
		$this->assertSame('tag-3', $t->name);
		$this->assertSame($u->id, $t->user_id);
	});
});

describe('createEtype()', function (): void {
	test('should create an etype', function (): void {
		$u = User::findByEmail('user-1@example.com');
		$etype = $u->createEtype(['name' => 'Etype', 'description' => 'Etype description']);
		$this->assertSame('Etype', $etype->name);
		$this->assertSame('Etype description', $etype->description);
		$this->assertSame($u->id, $etype->user_id);
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

describe('findEtypeById()', function (): void {
	test('should return corresponding etype when it exists', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$this->assertNotNull($u->findEtypeById($u->etypes[0]->id));
	});

	test('should return null when etype does not exist', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertNull(User::findByEmail('user-1@example.com')->findEtypeById(fake()->uuid()));
	});

	test('should return null when accessing a etype for another user', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertNull(User::findByEmail('user-1@example.com')->findEtypeById(User::findByEmail('user-2@example.com')->etypes[0]->id));
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

describe('findTagsByQuery()', function (): void {
	test('should return all tags when then query is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$result = [...User::findByEmail('user-1@example.com')->findTagsByQuery('')];
		$this->assertSame(2, sizeof($result));
	});

	test('should return matching tags when the case matches', function (): void {
		/** @var \Tests\TestCase $this */
		$result = [...User::findByEmail('user-1@example.com')->findTagsByQuery('g-1')];
		$this->assertSame(1, sizeof($result));
		$this->assertSame('tag-1', $result[0]->name);
	});

	test('should return matching tags when the case doesn\'t match', function (): void {
		/** @var \Tests\TestCase $this */
		$result = [...User::findByEmail('user-1@example.com')->findTagsByQuery('G-1')];
		$this->assertSame(1, sizeof($result));
		$this->assertSame('tag-1', $result[0]->name);
	});

	test('should return an empty collection when no tag matches the query', function (): void {
		/** @var \Tests\TestCase $this */
		$result = [...User::findByEmail('user-1@example.com')->findTagsByQuery('unknown')];
		$this->assertEmpty($result);
	});
});

describe('findEtypesByQuery()', function (): void {
	test('should return all etypes when then query is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$result = [...User::findByEmail('user-1@example.com')->findEtypesByQuery('')];
		$this->assertSame(2, sizeof($result));
	});

	test('should return matching etypes when the case matches', function (): void {
		/** @var \Tests\TestCase $this */
		$result = [...User::findByEmail('user-1@example.com')->findEtypesByQuery('Etype 1')];
		$this->assertSame(1, sizeof($result));
		$this->assertSame('Etype 1', $result[0]->name);
	});

	test('should return matching etypes when the case doesn\'t match', function (): void {
		/** @var \Tests\TestCase $this */
		$result = [...User::findByEmail('user-1@example.com')->findEtypesByQuery('etype 1')];
		$this->assertSame(1, sizeof($result));
		$this->assertSame('Etype 1', $result[0]->name);
	});

	test('should return an empty collection when no tag matches the query', function (): void {
		/** @var \Tests\TestCase $this */
		$result = [...User::findByEmail('user-1@example.com')->findEtypesByQuery('unknown')];
		$this->assertEmpty($result);
	});

	test('should find by description', function (): void {
		/** @var \Tests\TestCase $this */
		$result = [...User::findByEmail('user-1@example.com')->findEtypesByQuery('desc')];
		$this->assertSame(1, sizeof($result));
		$this->assertSame('Etype 2', $result[0]->name);
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
