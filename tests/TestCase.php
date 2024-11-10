<?php
namespace Tests;

use Illuminate\Contracts\Container\BindingResolutionException;
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

	/**
	 * Render Blade component and return DOM-object to assert XPath against.
	 * @param string $component Component class name.
	 * @param array $data Optional component parameters.
	 * @return TestDOM
	 * @throws BindingResolutionException
	 * ```php
	 * $this->domComponent(Alert::class, [])->assertExists('//p[@class = "alert"]');
	 * ```
	 */
	public function domComponent(string $component, array $data = []): TestDOM {
		return $this->dom((string) $this->component($component, $data)->component->render());
	}
}
