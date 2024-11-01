<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

/**
 * Show default page for authorized users.
 * @package App\Http\Controllers
 */
final class AccountController extends Controller {

	public function __invoke(): RedirectResponse {
		$firstMenuItem = menu('account')[0];
		return to_lroute($firstMenuItem->routeName);
	}
}
