<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsPasswordController extends Controller {

	public function get(): View {
		return view('page.settings.password', [
			'title' => __('page.settings.password.title')
		]);
	}

	public function put(Request $request): View | RedirectResponse {
		$input = $request->validate([
			'old' => 'required|filled|current_password',
			'new' => 'required|filled',
			'repeat' => 'required|filled'
		]);
		if ($input['new'] !== $input['repeat'])
			return back()->withErrors([
				'repeat' => __('message.user.password.doesNotMatch')
			]);
		$user = auth()->user();
		$user->password = $input['new'];
		$result = $user->save();
		return view('page.message', [
			'title' => __('page.settings.password.title'),
			'message' => __('message.user.password.' . ($result ? 'changed' : 'cannotChange')),
			'type' => $result ? 'success' : 'danger'
		]);
	}
}
