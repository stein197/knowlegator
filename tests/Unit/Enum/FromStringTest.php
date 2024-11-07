<?php
namespace Tests\Unit\Enum;

use App\Enum\FromString;

describe('name()', function (): void {
	test('should return lowercased name', function (): void {
		$this->assertSame('firstcase', TestEnum::FirstCase->name());
	});
});

describe('from()', function (): void {
	test('should return null when case does not exist', function (): void {
		$this->assertNull(TestEnum::from('NoCase'));
	});

	test('should return case when case exists and string case matches exactly', function (): void {
		$this->assertSame(TestEnum::FirstCase, TestEnum::from('FirstCase'));
	});

	test('should return case when case exists and string case does not match', function (): void {
		$this->assertSame(TestEnum::FirstCase, TestEnum::from('firstcase'));
	});
});

describe('names()', function (): void {
	test('should return original names when lcase is false', function (): void {
		$this->assertSame(['FirstCase', 'SecondCase'], TestEnum::names(false));
	});

	test('should return lowercased names when lcase is true', function (): void {
		$this->assertSame(['firstcase', 'secondcase'], TestEnum::names(true));
	});
});

enum TestEnum {

	use FromString;

	case FirstCase;
	case SecondCase;
}
