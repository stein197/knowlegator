<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\ThemeService;
use Illuminate\Http\RedirectResponse;

class ThemeController extends Controller {

	public function __construct(
		private readonly ThemeService $themeService
	) {}

	public function __invoke(): RedirectResponse {
		$this->themeService->toggle();
		return back();
	}
}
