<?php
namespace App\Http\Controllers;

use InvalidArgumentException;
use App\Enum\LoginAction;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

// TODO: Add "Forget Password?" functionality
/**
 * Contains the functionality to manage the process of authentication and registration.
 * @package App\Http\Controllers
 */
final class LoginController extends Controller {

	/**
	 * Show login form.
	 * @return View
	 * @throws BindingResolutionException
	 */
	public function get(): View {
		return view('page.login', [
			'title' => 'Knowlegator'
		]);
	}

	/**
	 * Login or register a user.
	 * @param Request $request
	 * @return View|RedirectResponse
	 * @throws BindingResolutionException
	 * @throws RouteNotFoundException
	 * @throws InvalidArgumentException
	 * @throws HttpException
	 * @throws NotFoundHttpException
	 * @throws HttpResponseException
	 */
	public function post(Request $request): View | RedirectResponse {
		$action = LoginAction::from($request->post('action'));
		return match ($action) {
			LoginAction::Login => $this->login($request),
			LoginAction::Register => $this->register($request),
			default => abort(400)
		};
	}

	private function login(Request $request): View | RedirectResponse {
		$credentials = $request->validate([
			'email' => 'required|filled|email',
			'password' => 'required|filled'
		]);
		$email = $credentials['email'];
		$user = User::where('email', $email)->first();
		if (!$user)
			return view('page.message', [
				'title' => __('oops'),
				'message' => __('message.user.doesNotExist', ['user' => $email]),
				'type' => 'danger'
			]);
		$result = Auth::attempt($credentials, $request->has('remember'));
		return $result ? to_lroute('account') : view('page.message', [
			'title' => __('oops'),
			'message' => __('message.user.cannotLogin', ['user' => $email]),
			'type' => 'danger'
		]);
	}

	private function register(Request $request): View {
		$credentials = $request->validate([
			'email' => 'required|filled|email|unique:users',
			'password' => 'required|filled'
		]);
		$user = new User($credentials);
		$email = $credentials['email'];
		$result = $user->save();
		$message = __($result ? 'message.user.created' : 'message.user.cannotCreate', ['user' => $email]);
		return view('page.message', [
			'title' => $message,
			'message' => $message,
			'type' => $result ? 'success' : 'danger'
		]);
	}
}
