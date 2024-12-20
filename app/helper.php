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
 * @param array $parameters Route parameters.
 * @return RedirectResponse
 * @throws BindingResolutionException
 * @throws RouteNotFoundException
 * @throws InvalidArgumentException
 */
function to_lroute(string $name, array $parameters = []): RedirectResponse {
	return to_route($name, ['locale' => app()->getLocale(), ...$parameters]);
}
