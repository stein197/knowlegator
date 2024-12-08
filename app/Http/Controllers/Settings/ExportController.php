<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\ImportExportService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

// TODO
class ExportController extends Controller {

	public function __construct(
		private readonly ImportExportService $ieService,
		Request $request
	) {
		parent::__construct($request);
	}

	public function __invoke(): View {
		return view('page.settings.export', [
			'title' => __('page.settings.export.title')
		]);
	}
}
