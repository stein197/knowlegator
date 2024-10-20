<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Log the current authenticated user out.
 * @package App\Http\Controllers
 */
class LogoutController extends Controller {

	public function __invoke(): RedirectResponse {
		Auth::logout();
		session()->invalidate();
		session()->regenerateToken();
		return to_route('login');
	}
}
