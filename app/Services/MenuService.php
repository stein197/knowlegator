<?php
namespace App\Services;

use App\Records\MenuRecord;
use Generator;
use Illuminate\Http\Request;

final class MenuService {

	/** @var MenuRecord[] */
	private array $cache = [];

	public function __construct(
		private readonly Request $request
	) {}

	/**
	 * Return an array of menu records for the given key registered by the `register()` method.
	 * @param string $name Menu name.
	 * @return Generator<int,MenuRecord>|null Menu generator or null if the menu is not defined
	 */
	public function get(string $name): ?Generator {
		$f = @$this->cache[$name];
		/** @var MenuRecord[] */
		$menu = $f ? $f() : null;
		if (!$menu)
			return null;
		foreach ($menu as $item)
			yield $item->with(['active' => $this->isActive($item)]);
	}

	/**
	 * Register a menu by the provided id.
	 * @param string $name Menu id.
	 * @param MenuRecord[] $menu Function that should return an array of menu records.
	 * @return void
	 */
	public function register(string $name, callable $menu): void {
		$this->cache[$name] = $menu;
	}

	private function isActive(MenuRecord $menu): bool {
		$requestRouteURI = explode('/', $this->request->getRequestUri());
		$routeURI = explode('/', $menu->link);
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
