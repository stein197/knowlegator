<?php
namespace App\Services;

use App\Records\BreadcrumbRecord;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollectionInterface;
use function array_unshift;
use function explode;
use function preg_replace;
use function sizeof;

final class BreadcrumbService {

	private array $cache = [];

	public function __construct(
		private Request $request,
		// private Application $app
	) {}

	public function get(string $name): ?iterable {
		return $this->exists($name) ? $this->cache[$name]($this->request) : null;
	}

	public function exists(string $name): bool {
		return isset($this->cache[$name]);
	}

	public function register(string $name, callable $f): void {
		$this->cache[$name] = $f;
	}
}
