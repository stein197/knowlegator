<?php
namespace App\Http\Controllers\Settings;

use App\Enum\Http\Method;
use App\Form;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogoutController;
use App\View\Components\Button;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Deletes an account for the current authorized user.
 * @package App\Http\Controllers
 */
class DeleteController extends Controller {

	public function get(): View {
		return view('page.settings.delete', [
			'title' => __('page.settings.delete.title'),
			'form' => new Form(
				method: Method::DELETE,
				action: lroute('settings.delete'),
				alert: [
					'type' => 'danger',
					'message' => __('page.settings.delete.consequences')
				],
				buttons: [
					new Button(
						label: __('action.cancel'),
						variant: 'warning',
						href: lroute('settings.password')
					),
					new Button(
						label: __('yes'),
						variant: 'danger',
						type: 'submit'
					)
				]
			)
		]);
	}

	public function delete(): RedirectResponse {
		app(LogoutController::class)();
		$this->user?->forceDelete();
		return $this->redirect('login');
	}
}
