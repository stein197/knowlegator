<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\ImportExportService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

// TODO
class ImportController extends Controller {

	public function __construct(
		private readonly ImportExportService $importExportService,
		Request $request
	) {
		parent::__construct($request);
	}

	public function get(): View {
		return view('page.settings.import', [
			'title' => __('page.settings.import.title')
		]);
	}

	public function post(): View {
		return view('page.settings.import', [
			'title' => __('page.settings.import.title')
		]);
	}
}
