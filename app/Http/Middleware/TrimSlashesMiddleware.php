<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function preg_replace;
use function rtrim;

/**
 * Trim the trailing slash from the end of URLs and redirect to the same URL but without one.
 * @package App\Http\Middleware
 */
final readonly class TrimSlashesMiddleware {

	/**
	 * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response {
		$path = $request->getRequestUri();
		$newPath = rtrim(preg_replace('/\\/+/', '/', $path), '/');
		return $path === $newPath ? $next($request) : redirect($newPath);
	}
}
