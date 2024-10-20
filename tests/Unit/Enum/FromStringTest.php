<?php
namespace Tests\Unit\Enum;

use App\Enum\FromString;
use Tests\TestCase;

final class FromStringTest extends TestCase {

	public function testFromShouldReturnNullWhenCaseDoesNotExist(): void {
		$this->assertNull(TestEnum::from('SecondCase'));
	}

	public function testFromShouldReturnCaseWhenCaseExistsAndStringCaseMatchesExactly(): void {
		$this->assertSame(TestEnum::FirstCase, TestEnum::from('FirstCase'));
	}
	
	public function testFromShouldReturnCaseWhenCaseExistsAndStringCaseDoesNotMatch(): void {
		$this->assertSame(TestEnum::FirstCase, TestEnum::from('firstcase'));
	}
}

enum TestEnum {
	
	use FromString;

	case FirstCase;
}