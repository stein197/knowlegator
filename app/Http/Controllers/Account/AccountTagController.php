<?php
namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountTagController extends Controller {

	public function showPost(): View {
		return view('page.account.tag.create', [
			'title' => __('page.account.tag.create.title')
		]);
	}

	public function showDelete(): void {
		// TODO
	}

	public function get(): void {
		// TODO
	}

	public function post(Request $request): void {
		// TODO
	}

	public function put(): void {
		// TODO
	}

	public function delete(): void {
		// TODO
	}
}
