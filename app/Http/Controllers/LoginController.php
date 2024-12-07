<?php
namespace App\Http\Controllers;

use App\Enum\Http\Method;
use InvalidArgumentException;
use App\Enum\LoginAction;
use App\Fields\CheckboxField;
use App\Fields\EmailField;
use App\Fields\PasswordField;
use App\Form;
use App\Models\User;
use App\Records\ButtonRecord;
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
			'title' => 'Knowlegator',
			'form' => static::getForm(LoginAction::Login)
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
		$form = self::getForm(LoginAction::Login);
		$form->applyRequest($request);
		$credentials = [
			'email' => $form->field('email')->value,
			'password' => $form->field('password')->value
		];
		$email = $credentials['email'];
		$user = User::findByEmail($email);
		if (!$user)
			return $this->redirect('login')->with('alert', [
				'type' => 'danger',
				'message' => __('message.user.doesNotExist', ['user' => $email]),
			]);
		$result = Auth::attempt($credentials, $request->has('remember'));
		return $result ? $this->redirect('account') : $this->redirect('login')->with('alert', [
			'message' => __('message.user.cannotLogin', ['user' => $email]),
			'type' => 'danger'
		]);
	}

	private function register(Request $request): RedirectResponse {
		$form = self::getForm(LoginAction::Register);
		$form->applyRequest($request);
		$credentials = [
			'email' => $form->field('email')->value,
			'password' => $form->field('password')->value
		];
		$user = new User($credentials);
		$email = $credentials['email'];
		$result = $user->save();
		$message = $result ? __('message.user.created', ['user' => $email]) : __('message.user.cannotCreate', ['user' => $email]);
		return $this->redirect('login')->with('alert', [
			'message' => $message,
			'type' => $result ? 'success' : 'danger'
		]);
	}

	protected static function getForm(LoginAction $action): Form {
		return new Form(
			title: __('page.login.title'),
			alert: session()->get('alert'),
			action: lroute('login'),
			method: Method::POST,
			fields: [
				new EmailField(
					label: __('form.field.email'),
					name: 'email',
					required: true,
					validate: $action === LoginAction::Login ? 'required|filled|email' : 'required|filled|email|unique:users'
				),
				new PasswordField(
					label: __('form.field.password'),
					name: 'password',
					required: true,
					validate: 'required|filled'
				),
				new CheckboxField(
					label: __('form.field.remember'),
					name: 'remember'
				)
			],
			buttons: [
				new ButtonRecord(
					label: __('form.button.login'),
					type: 'primary',
					name: 'action',
					value: 'login'
				),
				new ButtonRecord(
					label: __('form.button.register'),
					type: 'success',
					name: 'action',
					value: 'register'
				)
			],
		);
	}
}
