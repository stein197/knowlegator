<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * Build an absolute localized route (without hostname) with the current locale.
 * @param string $name Route name.
 * @return string Resolved URL.
 * @throws BindingResolutionException
 * ```php
 * lroute('login'); // '/en/login'
 * ```
 */
function lroute(string $name): string {
	return route($name, ['locale' => app()->getLocale()], false);
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