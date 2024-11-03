<?php

use App\Records\MenuRecord;
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

/**
 * Return or register menu items.
 * @param string $key Key by which to return or register the menu.
 * @param null|callable $f Function that is called when the specified menu is returned. Accepts a `Request` object. If
 *                         the function is passed, registers a new menu. A function should return an array of
 *                         `MenuRecord` objects.
 * @return null|MenuRecord[] Array of menu items returned from the function or `null` when the menu is undefined.
 * ```php
 * menu('main', fn (Request $request): array => [new MenuRecord(...)]);
 * menu('main'); // [...]
 * ```
 */
function menu(string $key, ?callable $f = null): ?array {
	static $cache = [];
	if ($f)
		$cache[$key] = $f;
	return @$cache[$key] ? $cache[$key](request()) : null;
}
