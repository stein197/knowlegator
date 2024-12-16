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

	public function store(): View | RedirectResponse {
		$this->request->validate([
			'name' => ['required', 'filled', new TagNotExistsRule($this->user)]
		]);
		$name = $this->request->post('name', '');
		try {
			$tag = $this->user->createTag(['name' => $name]);
			$tag->save();
			$this->user->refresh();
			return $this->redirect('tags.edit', ['tag' => $tag->id])->with('alert', [
				'type' => 'success',
				'message' => __('message.tag.created', ['name' => $name])
			]);
		} catch (TagInvalidNameException $ex) {
			return $this->redirect('tags.create')->withErrors([
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
			'name' => ['required', 'filled', new TagNotExistsRule($this->user)]
		]);
		$name = $this->request->post('name');
		try {
			$tag->name = $name;
			$result = $tag->save();
			return $this->redirect('tags.edit', ['tag' => $tag->id])->with('alert', [
				'type' => $result ? 'success' : 'danger',
				'message' => $result ? __('message.tag.updated', ['tag' => $name]) : __('message.tag.cannotUpdate', ['tag' => $name])
			]);
		} catch (TagInvalidNameException $ex) {
			return $this->redirect('tags.edit', ['tag' => $tag->id])->withErrors([
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
