<?php
namespace App\Services;

use function array_filter;
use function array_map;
use function scandir;
use function str_replace;

final class LocaleService {

	/**
	 * Return an array of defined locales, where keys are codes and values are the information, where `name` is a
	 * translated name and `flag-icon` is an icon name for the flag-icon CSS library.
	 * @return array Defined locales.
	 */
	public function locales(): array {
		static $cache = [];
		if (!$cache) {
			$keys = array_map(
				fn (string $name): string => str_replace('.json', '', $name),
				array_filter(
					scandir(base_path('lang')),
					fn (string $name): bool => $name !== '.' && $name !== '..'
				)
			);
			foreach ($keys as $k)
				$cache[$k] = [
					'name'      => __('locale.name', [], $k),
					'flag-icon' => __('locale.flag-icon', [], $k)
				];
		}
		return $cache;
	}
}