<?php
namespace Tests\Feature;

use App\Models\EType;
use App\Models\Tag;

describe('static getPublicAttributes()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame(['name'], Tag::getPublicAttributes());
		$this->assertSame(['name'], EType::getPublicAttributes());
	});
});
