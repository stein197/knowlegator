<?php
namespace App\Providers;

use App\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as RouteFacade;
use Illuminate\Support\ServiceProvider;
use function array_filter;
use function array_map;
use function explode;
use function sizeof;

final class MenuProvider extends ServiceProvider {

	public function register(): void {
		$this->registerMenuFor('account');
		$this->registerMenuFor('settings');
	}

	private function registerMenuFor(string $prefix): void {
		menu($prefix, fn (Request $request): array => [...array_map(
			fn (Route $route): MenuItem => new MenuItem(
				title: __('page.' . $route->getName() . '.title'),
				link: lroute($route->getName()),
				routeName: $route->getName(),
				active: static::isActive($request, $route)
			),
			array_filter(
				[...RouteFacade::getRoutes()],
				fn (Route $route): bool => str_starts_with($route->getName(), "$prefix.") && sizeof(explode('.', $route->getName())) === 2 // Only 2 level depth
			)
		)]);
	}

	private static function isActive(Request $request, Route $route): bool {
		$requestRouteURI = explode('/', $request->route()->uri());
		$routeURI = explode('/', $route->uri());
		if (sizeof($requestRouteURI) < sizeof($routeURI))
			return false;
		foreach ($routeURI as $i => $routePart) {
			$requestPart = $requestRouteURI[$i];
			if ($routePart !== $requestPart)
				return false;
		}
		return true;
	}
}
