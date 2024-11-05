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

// FIXME
final class BreadcrumbService {

	/** @var BreadcrumbRecord[] */
	private array $result = [];

	public function __construct(
		private Request $request,
		private Application $app
	) {}

	/**
	 * Return breadcrumb chain based on URL nesting.
	 * @return BreadcrumbRecord[]
	 */
	public function list(): array {
		if (!$this->result) {
			/** @var RouteCollectionInterface */
			$routes = $this->app->get('router')->getRoutes();
			$url = $this->request->getRequestUri();
			while (!self::isDepth($url, 2)) {
				// var_dump($url);
				$route = $routes->match($this->request->create($url));
				array_unshift($this->result, new BreadcrumbRecord(
					title: __('page.' . $route->getName() . '.title'),
					link: $url === $this->request->getRequestUri() || self::isDepth($url, 3) ? '' : $url
				));
				$url = self::getParentURL($url);
			}
		}
		return $this->result;
	}

	private static function getParentURL(string $url): string {
		return preg_replace('/\\/[^\\/]+$/', '', $url);
	}

	private static function isDepth(string $url, int $depth): bool {
		return sizeof(explode('/', $url)) === $depth;
	}
}
