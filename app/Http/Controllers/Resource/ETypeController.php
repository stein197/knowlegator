<?php
namespace App\Http\Controllers\Resource;

use App\Http\Controllers\ResourceController;
use App\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class ETypeController extends ResourceController {

	public function store(): RedirectResponse {
		$input = $this->request->validate([
			'name' => 'required|filled',
			'description' => ''
		]);
		$name = $this->request->post('name');
		$etype = $this->request->user()->createEtype($input);
		$result = $etype->save();
		return $result ? $this->redirect('etypes.edit', ['etype' => $etype->id])->with('alert', [
			'type' => 'success',
			'message' => __('message.etype.created', ['name' => $name])
		]) : $this->redirect('etypes.create')->with('alert', [
			'type' => 'danger',
			'message' => __('message.etype.couldNotCreate', ['name' => $name])
		]);
	}

	public function update(string $locale, string $id): RedirectResponse {
		$etype = $this->tryFetchModel($id);
		$input = $this->request->validate([
			'name' => 'required|filled',
			'description' => ''
		]);
		$name = $this->request->post('name');
		$etype->name = $name;
		$etype->description = @$input['description'];
		$result = $etype->save();
		return $this->redirect('etypes.edit', ['etype' => $etype->id])->with('alert', [
			'type' => $result ? 'success' : 'danger',
			'message' => $result ? __('message.etype.updated', ['name' => $name]) : __('message.etype.cannotUpdate', ['name' => $name])
		]);
	}

	protected function data(?string $query): Collection {
		return $this->user->findEtypesByQuery($query ?? '');
	}

	protected function model(string $id): ?Model {
		return $this->user->findEtypeById($id);
	}
}
