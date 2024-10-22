<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogoutController;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Deletes an account for the current authorized user.
 * @package App\Http\Controllers
 */
class SettingsDeleteController extends Controller {

	public function get(): View {
		return view('page.settings.delete', [
			'title' => __('page.settings.deleteAccount'),
			'h1' => __('page.settings.deleteAccount')
		]);
	}

	public function delete(): RedirectResponse {
		$user = auth()->user();
		app(LogoutController::class)();
		$user->forceDelete();
		return to_lroute('login');
	}
}
