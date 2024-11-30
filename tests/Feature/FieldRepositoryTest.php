<?php
namespace Tests\Feature;

use App\FieldRepository;

describe('all()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		/** @var FieldRepository */
		$repo = $this->createApplication()->get(FieldRepository::class);
		$this->assertContains('\\App\\Fields\\StringField', $repo->all());
	});
});
