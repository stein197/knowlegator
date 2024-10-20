<?php
namespace App\Services;

use Illuminate\Http\Request;
use function array_filter;
use function array_map;
use function file_get_contents;
use function in_array;
use function json_decode;
use function scandir;
use function str_replace;

final class LocaleService {

	public function default(): string {
		return config('app.locale');
	}

	/**
	 * Return an array of defined locales, where keys are codes and values are the information, where `name` is a
	 * translated name, `flag-icon` is an icon name for the flag-icon CSS library and `url` is a link to the current
	 * resource but with another locale.
	 * @param null|Request $request Request to build locale URLs for.
	 * @return array Defined locales.
	 */
	public function locales(?Request $request = null): array {
		static $cache = [];
		if (!$cache) {
			$route = $request?->route();
			foreach ($this->list() as $k) {
				$cfg = $this->config($k);
				$cache[$k] = [
					'name'      => $cfg['locale.name'],
					'flag-icon' => $cfg['locale.flag-icon'],
					'url'       => $route ? route($route->getName(), [...$route->parameters(), 'locale' => $k], false) : null
				];
			}
		}
		return $cache;
	}

	/**
	 * Check if the given locale exists.
	 * @param string $code Locale code.
	 * @return bool `true` if the locale exists.
	 */
	public function exists(string $code): bool {
		return in_array($code, $this->list());
	}

	private function list(): array {
		static $keys = [];
		if (!$keys) {
			$keys = array_map(
				fn (string $name): string => str_replace('.json', '', $name),
				array_filter(
					scandir(base_path('lang')),
					fn (string $name): bool => $name !== '.' && $name !== '..'
				)
			);
		}
		return $keys;
	}

	private function config(string $locale): array {
		static $config = [];
		if (!isset($config[$locale])) {
			$config[$locale] = json_decode(
				file_get_contents(base_path("lang/{$locale}.json")),
				true
			);
		}
		return $config[$locale];
	}
}