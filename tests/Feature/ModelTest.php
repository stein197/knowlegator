<?php
namespace Tests\Feature;

use App\Models\User;

describe('getPublicAttributes()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$u = User::findByEmail('user-1@example.com');
		$t = $u->tags[0];
		$this->assertSame(['name' => 'tag-1'], $t->getPublicAttributes());
	});
});
