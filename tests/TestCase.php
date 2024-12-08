<?php
namespace Tests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use function file_get_contents;
use function is_array;
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

	/**
	 * Assert that a full array contains a partial one as a subset.
	 * @param array $full Full array that should contain the partial one as a subset.
	 * @param array $partial Partial array which structure should be compliant with the full one.
	 * @return void
	 * ```php
	 * $this->assertArrayContains(['a' => 1, 'b' => ['c' => 3]], ['b' => ['c' => 3]]); // Passes
	 * $this->assertArrayContains(['a' => 1, 'b' => ['c' => 3]], ['d' => 4]);          // Fails
	 * ```
	 */
	public function assertArrayContains(array $full, array $partial): void {
		foreach ($partial as $k => $v) {
			$this->assertArrayHasKey($k, $full);
			if (is_array($full[$k]) && is_array($v))
				$this->assertArrayContains($full[$k], $v);
			else
				$this->assertSame($v, $full[$k]);
		}
	}
}
