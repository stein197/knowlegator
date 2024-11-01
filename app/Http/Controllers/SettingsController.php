<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

/**
 * Show the settings page
 * @package App\Http\Controllers
 */
final class SettingsController extends Controller {

	public function __invoke(): RedirectResponse {
		$firstMenuItem = menu('settings')[0];
		return to_lroute($firstMenuItem->routeName);
	}
}
