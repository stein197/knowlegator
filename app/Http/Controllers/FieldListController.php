<?php
namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final class FieldListController extends Controller {

	public function __invoke(): View {
		return view('page.fields', [
			'title' => __('page.fields.title'),
			'desc' => __('page.fields.desc')
		]);
	}
}
