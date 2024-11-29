<?php
namespace App;

use function array_filter;
use function explode;
use function sizeof;

/**
 * Return array entries. Opposite of `array_from_entries()`.
 * @param array $array Array to return entries from.
 * @return array Array of entries, the first element is key, the second is value.
 * ```php
 * array_entries(['a' => 1]); // [['a', 1]]
 * ```
 */
function array_entries(array $array): array {
	$result = [];
	foreach ($array as $k => $v)
		$result[] = [$k, $v];
	return $result;
}

/**
 * Create an array from entries. Opposite of `array_entries()`.
 * @param array $entries Entries to create an array from.
 * @return array Array with keys and values from the entries.
 * ```php
 * array_from_entries([['a', 1]]); // ['a' => 1]
 * ```
 */
function array_from_entries(array $entries): array {
	$result = [];
	foreach ($entries as [$k, $v])
		$result[$k] = $v;
	return $result;
}

/**
 * Get the last array's element.
 * @param array $array Array to get an element from.
 * @return mixed Last array element.
 * ```php
 * array_get_last(['a', 'b', 'c']); // 'c'
 * ```
 */
function array_get_last(array $array): mixed {
	return $array ? $array[sizeof($array) - 1] : null;
}

/**
 * Return class name without namespace.
 * @param string $fqcn Fully qualified class name.
 * @return string Class name without namespace.
 * ```php
 * class_get_name('App\\Http\\Controller'); // 'Controller'
 * ```
 */
function class_get_name(string $fqcn): string {
	$parts = explode('\\', $fqcn);
	return array_get_last($parts);
}

/**
 * Split path into an array of segments
 * @param string $path Path to split
 * @return string[] Segments
 * ```php
 * path_split('/en/settings'); // ['en', 'settings']
 * ```
 */
function path_split(string $path): array {
	return [...array_filter(
		explode('/', $path),
		fn (string $segment): bool => $segment !== ''
	)];
}
