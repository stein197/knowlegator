<?php
namespace App\Http\Controllers\Resource;

use App\Http\Controllers\ResourceController;
use App\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class ETypeController extends ResourceController {

	public function store(): View {
		$this->request->validate([
			'name' => 'required|filled'
		]);
		$name = $this->request->post('name');
		$etype = $this->request->user()->createEtype($name);
		$result = $etype->save();
		return view('page.message', [
			'title' => __('resource.etype.create.title'),
			'type' => $result ? 'success' : 'danger',
			'message' => __($result ? 'message.etype.created' : 'message.etype.couldNotCreate', ['name' => $name])
		]);
	}

	public function update(Request $request, string $id): void {} // TODO

	protected function data(?string $query): Collection {
		return $this->user->findEtypesByQuery($query ?? '');
	}

	protected function model(string $id): ?Model {
		return $this->user->findEtypeById($id);
	}
}
