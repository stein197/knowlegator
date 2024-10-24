<?php
namespace Tests\Unit\Enum;

use App\Enum\FromString;
use Tests\TestCase;

final class FromStringTest extends TestCase {

	public function testFromShouldReturnNullWhenCaseDoesNotExist(): void {
		$this->assertNull(TestEnum::from('NoCase'));
	}

	public function testFromShouldReturnCaseWhenCaseExistsAndStringCaseMatchesExactly(): void {
		$this->assertSame(TestEnum::FirstCase, TestEnum::from('FirstCase'));
	}
	
	public function testFromShouldReturnCaseWhenCaseExistsAndStringCaseDoesNotMatch(): void {
		$this->assertSame(TestEnum::FirstCase, TestEnum::from('firstcase'));
	}

	public function testNamesShouldReturnOriginalNamesWhenLcaseIsFalse(): void {
		$this->assertSame(['FirstCase', 'SecondCase'], TestEnum::names(false));
	}

	public function testNamesShouldReturnLowercasedNamesWhenLcaseIsTrue(): void {
		$this->assertSame(['firstcase', 'secondcase'], TestEnum::names(true));
	}
}

enum TestEnum {
	
	use FromString;

	case FirstCase;
	case SecondCase;
}