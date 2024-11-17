<?php
// TODO: Replace the path_* functions with stein197/path
namespace App;

/**
 * Return array entries.
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
