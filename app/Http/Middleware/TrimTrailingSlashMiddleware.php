<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function str_ends_with;
use function rtrim;

/**
 * Trim the trailing slash from the end of URLs and redirect to the same URL but without one.
 * @package App\Http\Middleware
 */
final readonly class TrimTrailingSlashMiddleware {

	/**
	 * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response {
		$path = $request->getRequestUri();
		return str_ends_with($path, '/') && $path !== '/' ? redirect(rtrim($path, '/')) : $next($request);
	}
}
