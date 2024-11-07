<?php
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * Build an absolute localized route (without hostname) with the current locale.
 * @param string $name Route name.
 * @param array $parameters Route parameters.
 * @return string Resolved URL.
 * @throws BindingResolutionException
 * ```php
 * lroute('login'); // '/en/login'
 * ```
 */
function lroute(string $name, array $parameters = []): string {
	return route($name, ['locale' => app()->getLocale(), ...$parameters], false);
}

/**
 * Return a localized redirect route with the current locale.
 * @param string $name Route name.
 * @return RedirectResponse
 * @throws BindingResolutionException
 * @throws RouteNotFoundException
 * @throws InvalidArgumentException
 */
function to_lroute(string $name): RedirectResponse {
	return to_route($name, ['locale' => app()->getLocale()]);
}

// TODO: Extract to a library
/**
 * Take an array of strings and convert into an HTML classname.
 * @param array|string|null ...$classname Classnames. Empty values are not considered.
 * @return string CSS-class.
 * ```php
 * classname('a', null, 'b'); // 'a b'
 * classname(['a', 'b']);     // 'a b'
 * classname(['a' => true, 'b' => false, 'c', null], 'd', ['e']); // 'a c d e'
 * ```
 */
function classname(array | string | null ...$classname): string {
	$result = [];
	foreach ($classname as $arg)
		if (is_array($arg))
			foreach ($arg as $k => $v) {
				if (is_int($k) && $v)
					$result[] = $v;
				elseif ($v)
					$result[] = $k;
			}
		elseif ($arg)
			$result[] = $arg;
	return join(' ', $result);
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

// TODO: Delete if unused
/**
 * Try to singularize an english word.
 * @param string $word Word to singularize.
 * @return string Singularized word if the word is plural or the original one if the word isn't plural.
 * ```php
 * singularize('words');      // 'word'
 * singularize('word');       // 'word'
 * ```
 */
function singularize(string $word): string {
	static $rules = [
		'/zzes$/i' => 'z',
		'/(ss|sh|ch)es$/i' => '\\1',
		'/ies$/i' => 'y',
		'/(a|e|i|o|u)ys$/i' => '\\1y',
		'/(o|s|x|z)es$/i' => '\\1',
		'/es$/i' => 'is',
		'/(b|c|d|f|g|h|j|k|l|m|n|p|q|r|s|t|v|w|x|y|z)i$/i' => '\\1us',
		'/s$/i' => '',
		'/a$/i' => 'on'
	];
	static $exceptions = [
		'busses' => 'bus',
		'children' => 'child',
		'deer' => 'deer',
		'feet' => 'foot',
		'geese' => 'goose',
		'halos' => 'halo',
		'indices' => 'index',
		'oxen' => 'ox',
		'people' => 'person',
		'photos' => 'photo',
		'pianos' => 'piano',
		'matrices' => 'matrix',
		'men' => 'man',
		'mice' => 'mouse',
		'movies' => 'movie',
		'news' => 'news',
		'series' => 'series',
		'sheep' => 'sheep',
		'species' => 'species',
		'teeth' => 'tooth',
		'toes' => 'toe',
		'vertices' => 'vertex',
		'wives' => 'wife',
		'wolves' => 'wolf',
		'women' => 'woman'
	];
	if (@$exceptions[$word])
		return $exceptions[$word];
	foreach ($rules as $regex => $replacement)
		if (preg_match($regex, $word))
			return preg_replace($regex, $replacement, $word);
	return $word;
}
