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

class MenuProvider extends ServiceProvider {

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
				active: $request->route() === $route // TODO: Check for parents
			),
			array_filter(
				[...RouteFacade::getRoutes()],
				fn (Route $route): bool => str_starts_with($route->getName(), "$prefix.") && sizeof(explode('.', $route->getName())) === 2 // Only 2 level depth
			)
		)]);
	}
}
