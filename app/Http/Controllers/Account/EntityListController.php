<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EntityListController extends Controller {

	public function __invoke(): View {
		return view('page.account.entity-list', [
			'title' => __('page.account.entity-list.title')
		]);
	}
}
