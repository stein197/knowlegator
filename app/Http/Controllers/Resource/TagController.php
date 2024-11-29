<?php
namespace App\Http\Controllers\Resource;

use App\Exceptions\TagInvalidNameException;
use App\Http\Controllers\ResourceController;
use App\Model;
use App\Rules\TagNotExistsRule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends ResourceController {

	// TODO: Redirect to tags.edit on successfull save
	public function store(): View | RedirectResponse {
		$this->request->validate([
			'name' => ['required', 'filled', new TagNotExistsRule($this->request->user())]
		]);
		$name = $this->request->post('name', '');
		try {
			$tag = $this->request->user()->createTag($name);
			$tag->save();
			return view('page.message', [
				'title' => __('resource.tag.create.title'),
				'type' => 'success',
				'message' => __('message.tag.created', ['name' => $name])
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

	public function update(string $locale, string $id): View | RedirectResponse {
		$tag = $this->tryFetchModel($id);
		$this->request->validate([
			'name' => ['required', 'filled', new TagNotExistsRule($this->request->user())]
		]);
		$name = $this->request->post('name');
		try {
			$tag->name = $name;
			$result = $tag->save();
			return to_lroute('tags.edit', ['tag' => $tag->id])->with('alert', [
				'text' => $result ? __('message.tag.updated', ['tag' => $name]) : __('message.tag.cannotUpdate', ['tag' => $name]),
				'type' => $result ? 'success' : 'danger'
			]);
		} catch (TagInvalidNameException $ex) {
			return to_lroute('tags.edit', ['tag' => $tag->id])->withErrors([
				'name' => match ($ex->getCode()) {
					TagInvalidNameException::REASON_EMPTY => __('form.message.name.empty'),
					TagInvalidNameException::REASON_INVALID => __('form.message.name.invalid', ['name' => $name])
				}
			]);
		}
	}

	protected function data(?string $query): Collection {
		return $this->user->findTagsByQuery($query ?? '');
	}

	protected function model(string $id): ?Model {
		return $this->user->findTagById($id);
	}
}
