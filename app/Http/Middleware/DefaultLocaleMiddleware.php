<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Set default locale parameter when calling route-related functions.
 * @package App\Http\Middleware
 */
class DefaultLocaleMiddleware {

	/**
	 * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
	 */
	public function handle(Request $request, Closure $next): Response {
		URL::defaults(['locale' => app()->getLocale()]);
		return $next($request);
	}
}
