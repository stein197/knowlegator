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
