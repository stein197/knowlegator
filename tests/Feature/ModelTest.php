<?php
namespace Tests\Feature;

use App\Fields\StringField;
use App\Fields\TextareaField;
use App\Models\EType;
use App\Models\Tag;

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
