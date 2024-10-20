<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

/**
 * Redirect users to the login or the account page depending on the authorization.
 * @package App\Http\Middleware
 */
class RedirectMiddleware {

	/**
	 * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
	 */
	public function handle(): RedirectResponse {
		return to_route(auth()->user() ? 'account' : 'login', ['locale' => app()->getLocale()]);
	}
}
