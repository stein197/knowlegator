<?php
namespace App\Http\Controllers\Settings;

use App\Enum\Theme;
use App\Http\Controllers\Controller;
use App\Services\ThemeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThemeController extends Controller {

	public function __construct(
		private readonly ThemeService $themeService
	) {}

	public function get(): View {
		return view('page.settings.theme', [
			'title' => __('page.settings.theme.title'),
			'themes' => [
				Theme::Light->name => [
					'title' => __('theme.light'),
					'active' => $this->themeService->get() === Theme::Light
				],
				Theme::Dark->name => [
					'title' => __('theme.dark'),
					'active' => $this->themeService->get() === Theme::Dark
				]
			],
		]);
	}

	public function put(Request $request): RedirectResponse {
		$this->themeService->set(Theme::from($request->post('theme')));
		return back();
	}
}
