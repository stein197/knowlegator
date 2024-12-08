<?php
namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Services\ImportExportService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExportController extends Controller {

	public function __construct(
		private readonly ImportExportService $ieService,
		Request $request
	) {
		parent::__construct($request);
	}

	public function __invoke(): View | Response {
		return $this->request->has('download') ? $this->download() : $this->show();
	}

	private function show(): View {
		return view('page.settings.export', [
			'title' => __('page.settings.export.title'),
			'message' => __('page.settings.export.message'),
			'href' => lroute('settings.export', ['download'])
		]);
	}

	private function download(): Response {
		return response($this->ieService->export(), 200, [
			'Content-Type' => 'application/json',
			'Content-Disposition' => 'attachment; filename = "' . env('APP_NAME') . '.json"'
		]);
	}
}
