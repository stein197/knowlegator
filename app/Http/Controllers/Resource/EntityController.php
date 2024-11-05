<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EntityController extends Controller {

	public function index(): View {
		return view('resource.entity.index', [
			'title' => __('resource.entity.index.title')
		]);
	}

	public function create(): void {} // TODO

	public function store(Request $request): void {} // TODO

	public function show(string $id): void {} // TODO

	public function edit(string $id): void {} // TODO

	public function update(Request $request, string $id): void {} // TODO

	public function destroy(string $id): void {} // TODO
}
