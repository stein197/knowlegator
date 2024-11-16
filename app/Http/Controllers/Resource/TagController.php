<?php
namespace App\Http\Controllers\Resource;

use App\Exceptions\TagInvalidNameException;
use App\Http\Controllers\ResourceController;
use App\Model;
use App\Models\Tag;
use App\Rules\TagNotExistsRule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends ResourceController {

	public function create(): View {
		return view('resource.tag.create', [
			'title' => __('resource.tag.create.title')
		]);
	}

	public function store(Request $request): View | RedirectResponse {
		$request->validate([
			'name' => ['required', 'filled', new TagNotExistsRule($request->user())]
		]);
		$name = $request->post('name', '');
		try {
			$tag = $request->user()->createTag($name);
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
					TagInvalidNameException::REASON_INVALID => __('form.message.name.invalid', ['name' => $name])
				}
			]);
		}
	}

	public function update(string $locale, string $tag, Request $request): View | RedirectResponse {
		$tag = self::fetchModel($request, $tag);
		$request->validate([
			'name' => ['required', 'filled', new TagNotExistsRule($request->user())]
		]);
		$name = $request->post('name');
		try {
			$tag->name = $name;
			$result = $tag->save();
			return self::viewEdit($tag, [
				'text' => __($result ? 'message.tag.updated' : 'message.tag.cannotUpdate', ['tag' => $name]),
				'type' => $result ? 'success' : 'danger'
			]);
		} catch (TagInvalidNameException $ex) {
			return back()->withErrors([
				'name' => match ($ex->getCode()) {
					TagInvalidNameException::REASON_EMPTY => __('form.message.name.empty'),
					TagInvalidNameException::REASON_INVALID => __('form.message.name.invalid', ['name' => $name])
				}
			]);
		}
	}

	public function destroy(string $locale, string $tag, Request $request): View {
		$tag = self::fetchModel($request, $tag);
		$result = $tag->forceDelete();
		return view('page.message', [
			'title' => __('resource.tag.delete.title'),
			'message' => __($result ? 'message.tag.deleted' : 'message.tag.cannotDelete', ['tag' => $tag->name]),
			'type' => $result ? 'success' : 'danger'
		]);
	}

	protected function data(?string $query): Collection {
		return $this->request->user()->findTagsByQuery($query ?? '');
	}

	protected function model(string $id): ?Model {
		return $this->request->user()->findTagById($id);
	}

	// TODO: Replace with tryGetModel()
	private static function fetchModel(Request $request, string $tag): Tag {
		return $request->user()->findTagById($tag) ?? abort(404);
	}

	private static function viewEdit(Tag $tag, array $message = []): View {
		return view('resource.tag.edit', [
			'title' => __('resource.tag.edit.title', ['tag' => $tag->name]),
			'tag' => $tag,
			'action' => lroute('tags.update', ['tag' => $tag->id]),
			'cancelUrl' => lroute('tags.show', ['tag' => $tag->id]),
			'message' => $message
		]);
	}
}
