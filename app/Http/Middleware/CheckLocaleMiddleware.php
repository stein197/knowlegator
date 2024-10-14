<?php
namespace App\Http\Middleware;

use App\Services\LocaleService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Check if the passed locale is correct. If so, the application changes its locale. If not, 404 is thrown.
 * @package App\Http\Middleware
 */
final readonly class CheckLocaleMiddleware {

	public function __construct(
		private LocaleService $localeService
	) {}

	/**
	 * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response {
		$route = $request->route();
		$urlLocale = $route->parameter('locale');
		if (!$this->localeService->exists($urlLocale))
			return abort(404);
		if (app()->getLocale() !== $urlLocale)
			app()->setLocale($urlLocale);
		return $next($request);
	}
}
