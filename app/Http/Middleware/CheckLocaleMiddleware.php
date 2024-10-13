<?php
namespace App\Http\Middleware;

use App\Services\LocaleService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
			return redirect()->route($route->getName(), [...$route->parameters, 'locale' => $this->localeService->default()]);
		if (app()->getLocale() !== $urlLocale)
			app()->setLocale($urlLocale);
		return $next($request);
	}
}
