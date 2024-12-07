<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use InvalidArgumentException;

abstract class Controller {

	protected readonly ?User $user;

	public function __construct(
		protected Request $request
	) {
		$this->user = $request->user();
	}

	/**
	 * Alias for `to_lroute()`.
	 * @param string $route Route name.
	 * @param array $parameters Route parameters.
	 * @return RedirectResponse
	 * @throws BindingResolutionException
	 * @throws RouteNotFoundException
	 * @throws InvalidArgumentException
	 * ```php
	 * $this->redirect('login');
	 * ```
	 */
	final protected function redirect(string $route, array $parameters = []): RedirectResponse {
		return to_lroute($route, $parameters);
	}
}
