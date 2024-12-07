<?php
namespace App\Http\Controllers\Settings;

use App\Enum\Http\Method;
use App\Fields\PasswordField;
use App\Form;
use App\Http\Controllers\Controller;
use App\Records\ButtonRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordController extends Controller {

	public function get(): View {
		return view('page.settings.password', [
			'title' => __('page.settings.password.title'),
			'form' => self::form()
		]);
	}

	public function put(Request $request): RedirectResponse {
		$form = self::form();
		$form->applyRequest($request);
		$input = $form->toArray();
		if ($input['new'] !== $input['repeat'])
			return $this->redirect('settings.password')->withErrors([
				'repeat' => __('message.user.password.doesNotMatch')
			]);
		$this->user->password = $input['new'];
		$result = $this->user->save();
		return $this->redirect('settings.password')->with('alert', [
			'message' => __('message.user.password.' . ($result ? 'changed' : 'cannotChange')),
			'type' => $result ? 'success' : 'danger'
		]);
	}

	private static function form(): Form {
		return new Form(
			action: lroute('settings.password'),
			alert: session()->get('alert'),
			method: Method::PUT,
			fields: [
				new PasswordField(
					label: __('form.field.oldPassword'),
					name: 'old',
					required: true,
					validate: 'required|filled|current_password'
				),
				new PasswordField(
					label: __('form.field.newPassword'),
					name: 'new',
					required: true,
					validate: 'required|filled'
				),
				new PasswordField(
					label: __('form.field.repeatPassword'),
					name: 'repeat',
					required: true,
					validate: 'required|filled'
				),
			],
			buttons: [
				new ButtonRecord(
					label: __('form.button.confirm'),
					type: 'primary'
				)
			]
		);
	}
}
