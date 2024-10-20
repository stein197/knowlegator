<?php
namespace App\Http\Controllers;

/**
 * Show the settings page
 * @package App\Http\Controllers
 */
final class SettingsController extends Controller {

	public function __invoke() {
		return view('page.settings', [
			'title' => __('page.settings.title'),
			'h1' => __('page.settings.title')
		]);
	}
}
