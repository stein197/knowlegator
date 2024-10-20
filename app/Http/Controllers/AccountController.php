<?php
namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Show default page for authorized users.
 * @package App\Http\Controllers
 */
final class AccountController extends Controller {

	public function __invoke(): View {
		return view('index', [
			'title' => __('page.account.title')
		]);
	}
}
