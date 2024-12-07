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
class DeleteController extends Controller {

	public function get(): View {
		return view('page.settings.delete', [
			'title' => __('page.settings.delete.title')
		]);
	}

	public function delete(): RedirectResponse {
		app(LogoutController::class)();
		$this->user?->forceDelete();
		return $this->redirect('login');
	}
}
