<?php
namespace Tests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use function file_get_contents;
use function json_decode;

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

	public function assertLocalizationExists(string $key, string $message = ''): void {
		static $json = null;
		if (!$json) {
			$locale = $this->app->getLocale();
			$json = json_decode(file_get_contents(base_path("lang/{$locale}.json")), true);
		}
		$this->assertArrayHasKey($key, $json, $message);
	}
}
