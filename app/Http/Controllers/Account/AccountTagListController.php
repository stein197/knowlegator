<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AccountTagListController extends Controller {

	public function __invoke(): View {
		return view('page.account.tag-list', [
			'title' => __('page.account.tag-list.title')
		]);
	}
}
