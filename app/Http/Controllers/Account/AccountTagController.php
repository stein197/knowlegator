<?php
namespace App\Http\Controllers\Account;

use App\Exceptions\TagInvalidNameException;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountTagController extends Controller {

	public function showCreate(): View {
		return view('page.account.tag.create', [
			'title' => __('page.account.tag.create.title')
		]);
	}

	public function showDelete(): void {
		// TODO
	}

	public function read(): void {
		// TODO
	}

	public function create(Request $request): View | RedirectResponse {
		$name = $request->post('name', '');
		try {
			$tag = new Tag([
				'name' => $name,
				'user_id' => $request->user()->id
			]);
			$tag->save();
			return view('page.message', [
				'title' => __('page.account.tag.create.title'),
				'type' => 'success',
				'message' => __('message.tag.created', ['tag' => $name])
			]);
		} catch (TagInvalidNameException $ex) {
			return back()->withErrors([
				'name' => match ($ex->getCode()) {
					TagInvalidNameException::REASON_EMPTY => __('form.message.name.empty'),
					TagInvalidNameException::REASON_INVALID => __('form.message.name.invalid', ['name' => $name]),
				}
			]);
		} catch (QueryException $ex) {
			return back()->withErrors([
				'name' => __('form.message.name.exists', ['name' => $name])
			]);
		}
	}

	public function update(): void {
		// TODO
	}

	public function delete(): void {
		// TODO
	}
}
