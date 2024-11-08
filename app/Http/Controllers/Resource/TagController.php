<?php
namespace App\Http\Controllers\Resource;

use App\Enum\Action;
use App\Exceptions\TagInvalidNameException;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller {

	public function index(): View {
		return view('resource.tag.index', [
			'title' => __('resource.tag.index.title'),
			'tags' => auth()->user()->tags
		]);
	}

	public function create(): View {
		return view('resource.tag.create', [
			'title' => __('resource.tag.create.title')
		]);
	}

	public function store(Request $request): View | RedirectResponse {
		$name = $request->post('name', '');
		try {
			$tag = new Tag([
				'name' => $name,
				'user_id' => $request->user()->id
			]);
			$tag->save();
			return view('page.message', [
				'title' => __('resource.tag.create.title'),
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

	public function show(string $locale, string $tag, Request $request): View {
		$tag = $request->user()->findTag($tag);
		if (!$tag)
			return abort(404);
		return view('resource.tag.show', [
			'title' => __(Action::from($request->query('action') ?? '') === Action::Delete ? 'resource.tag.delete.title' : 'resource.tag.show.title', ['tag' => $tag->name]),
			'tag' => $tag,
			'link' => [
				'delete' => url()->query($request->path(), ['action' => Action::Delete->name()])
			],
			'action' => Action::from($request->query('action') ?? '')
		]);
	}

	public function edit(string $id): void {} // TODO

	public function update(Request $request, string $id): void {} // TODO

	public function destroy(string $locale, string $tag, Request $request): View {
		$tag = $request->user()->findTag($tag);
		if (!$tag)
			return abort(404);
		$result = $tag->forceDelete();
		return view('page.message', [
			'title' => __('resource.tag.delete.title'),
			'message' => __($result ? 'message.tag.deleted' : 'message.tag.cannotDelete', ['tag' => $tag->name]),
			'type' => $result ? 'success' : 'danger'
		]);
	}
}
