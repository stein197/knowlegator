<?php
namespace Tests\Unit;

use App\Record;

describe('equals()', function (): void {
	test('should return false for null', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertFalse((new TestRecord())->equals(null));
	});

	test('should return false for another instance', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertFalse((new TestRecord)->equals(new \stdClass));
	});

	test('should return false when values are different', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertFalse((new TestRecord(a: 'first', b: 'second'))->equals(new TestRecord(a: 'first')));
	});

	test('should return true when values are the same', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertTrue((new TestRecord(a: 'first'))->equals(new TestRecord(a: 'first')));
	});
});

describe('with()', function (): void {
	test('should return clone when the array is empty', function (): void {
		/** @var \Tests\TestCase $this */
		$r = new TestRecord;
		$this->assertTrue($r->equals($r->with([])));
	});

	test('should override only one parameters', function (): void {
		/** @var \Tests\TestCase $this */
		$r = new TestRecord;
		$this->assertTrue((new TestRecord(a: 'first'))->equals($r->with(['a' => 'first'])));
	});

	test('should override all parameters', function (): void {
		/** @var \Tests\TestCase $this */
		$r = new TestRecord;
		$this->assertTrue((new TestRecord(a: 'first', b: 'second'))->equals($r->with(['a' => 'first', 'b' => 'second'])));
	});

	test('should not erase not listed properties', function (): void {
		/** @var \Tests\TestCase $this */
		$r = new TestRecord(a: 'first', b: 'second');
		$this->assertTrue((new TestRecord(a: 'first', b: 'SECOND'))->equals($r->with(['b' => 'SECOND'])));
	});
});

describe('toArray()', function (): void {
	test('should return an array', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertEquals(['a' => 'first', 'b' => 'second'], (new TestRecord(a: 'first', b: 'second'))->toArray());
	});
});

describe('fromArray()', function (): void {
	test('should return an instance when not all properties are defined', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertTrue((new TestRecord())->equals(TestRecord::fromArray([])));
		$this->assertTrue((new TestRecord(a: 'first'))->equals(TestRecord::fromArray(['a' => 'first'])));
	});

	test('should return an instance when all properties are defined', function (): void {
		/** @var \Tests\TestCase $this */
		$this->assertTrue((new TestRecord(a: 'first', b: 'second'))->equals(TestRecord::fromArray(['a' => 'first', 'b' => 'second'])));
	});
});

final readonly class TestRecord extends Record {
	public function __construct(
		public string $a = 'a',
		public string $b = 'b'
	) {}
}
