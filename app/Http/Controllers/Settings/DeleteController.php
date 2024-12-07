<?php
namespace App\Http\Controllers\Settings;

use App\Enum\Http\Method;
use App\Form;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogoutController;
use App\Records\ButtonRecord;
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
					new ButtonRecord(
						label: __('action.cancel'),
						type: 'warning',
						url: lroute('settings.password')
					),
					new ButtonRecord(
						label: __('yes'),
						type: 'danger'
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
