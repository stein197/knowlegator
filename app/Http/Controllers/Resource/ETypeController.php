<?php
namespace App\Http\Controllers\Resource;

use App\Http\Controllers\ResourceController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ETypeController extends ResourceController {

	public function create(): void {} // TODO

	public function store(Request $request): void {} // TODO

	public function show(string $id): void {} // TODO

	public function edit(string $id): void {} // TODO

	public function update(Request $request, string $id): void {} // TODO

	public function destroy(string $id): void {} // TODO

    protected function data(?string $query): Collection {
		return $this->request->user()->findEtypesByQuery($query ?? '');
	}
}
