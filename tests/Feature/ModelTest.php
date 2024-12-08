<?php
namespace Tests\Feature;

use App\Fields\StringField;
use App\Fields\TextareaField;
use App\Models\EType;
use App\Models\Tag;
use App\Models\User;

describe('getActionUrl()', function (): void {
	test('should return url', function (): void {
		/** @var \Tests\TestCase $this */
		$t = User::findByEmail('user-1@example.com')->tags[0];
		$this->assertSame("/en/account/tags/{$t->id}/edit", $t->getActionUrl('edit'));
	});
});

describe('static getPublicAttributes()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame(['name' => StringField::class], Tag::getPublicAttributes());
		$this->assertSame(['name' => StringField::class, 'description' => TextareaField::class], EType::getPublicAttributes());
	});
});

describe('static getTypeName()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertSame('tag', Tag::getTypeName());
		$this->assertSame('etype', EType::getTypeName());
	});
});
