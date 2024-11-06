<?php
namespace App\Services;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

final class BreadcrumbService {

	private array $cache = [];

	public function __construct(
		private readonly Application $app
	) {}

	public function get(string $name): ?iterable {
		return $this->exists($name) ? $this->cache[$name]($this->app->get(Request::class)) : null;
	}

	public function exists(string $name): bool {
		return isset($this->cache[$name]);
	}

	public function register(string $name, callable $f): void {
		$this->cache[$name] = $f;
	}
}
