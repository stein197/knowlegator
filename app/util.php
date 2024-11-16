<?php
// TODO: Replace the path_* functions with stein197/path
namespace App;

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
