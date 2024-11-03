<?php
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

// TODO: Use test database for testing
// TODO: Preserve test data instead of flushing
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
