<?php
namespace App\Http\Controllers;

use App\Services\ApplicationVersionService;
use App\Services\LocaleService;
use Illuminate\View\View;

final class LoginController extends Controller {

	public function __construct(
		private ApplicationVersionService $versionService,
		private LocaleService $localeService,
	) {}

	public function __invoke(): View {
		return view('page.login', [
			'title' => 'Knowlegator'
		]);
	}
}
