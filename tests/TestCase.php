<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {

	/**
	 * Test DOM structure.
	 * @param string $dom
	 * @return TestDOM
	 */
	public function dom(string $dom): TestDOM {
		return new TestDOM([$dom], $this);
	}
}
