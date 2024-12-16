<?php
namespace App\Http\Controllers;

use App\Model;
use App\Services\ModelFormService;
use App\Services\ModelRoutingService;
use App\View\Components\Button;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Pluralizer;
use function App\class_get_name;
use function is_string;
use function join;
use function str_replace;

abstract class ResourceController extends Controller {

	public function __construct(
		Request $request,
		protected readonly ModelRoutingService $modelRoutingService,
		protected readonly ModelFormService $modelFormService
	) {
		parent::__construct($request);
	}

	public function index(): View {
		$q = $this->request->query('q');
		$tName = static::getModelClass()::getTypeName();
		if (!is_string($q))
			$q = null;
		$data = $this->data($q);
		return $this->view('index', [
			'title' => __("resource.{$tName}.index.title"),
			'data' => $data,
			'alert' => session()->get('alert'),
			'search' => [
				'action' => '/' . $this->request->path(),
				'placeholder' => __("resource.{$tName}.index.search-placeholder"),
				'value' => $q,
			],
			'action' => [
				new Button(
					label: __("resource.{$tName}.create.title"),
					variant: 'outline-secondary',
					href: $this->modelRoutingService->route(static::getModelClass(), 'create'),
					icon: 'plus-lg'
				)
			]
		]);
	}

	public function create(): View {
		$class = static::getModelClass();
		$tName = $class::getTypeName();
		return $this->view('create', [
			'title' => __("resource.{$tName}.create.title"),
			'form' => $this->modelFormService->form($class, 'store')
		]);
	}

	public function edit(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelClass()::getTypeName();
		return $this->view('edit', [
			'title' => join(' / ', [__("resource.{$tName}.index.title"), __('action.edit'), $model->name]),
			'model' => $model,
			'alert' => $this->request->session()->get('alert'),
			'form' => $this->modelFormService->form($model, 'update')
		]);
	}

	public function show(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelClass()::getTypeName();
		return $this->view('show', [
			'title' => __("resource.{$tName}.index.title") . ' / ' . $model->name,
			'form' => $this->modelFormService->form($model, 'show'),
		]);
	}

	public function delete(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelClass()::getTypeName();
		return $this->view('delete', [
			'title' => join(' / ', [__("resource.{$tName}.index.title"), __('action.delete'), $model->name]),
			'model' => $model,
			'form' => $this->modelFormService->form($model, 'destroy')
		]);
	}

	public function destroy(string $locale, string $id): RedirectResponse {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelClass()::getTypeName();
		$routePrefix = Pluralizer::plural($tName);
		$result = $model->forceDelete();
		return $this->redirect("{$routePrefix}.index")->with('alert', [
			'message' => __($result ? "message.{$tName}.deleted" : "message.{$tName}.cannotDelete", ['name' => $model->name]),
			'type' => $result ? 'success' : 'danger',
			'dismissible' => true
		]);
	}

	final protected function view(string $action, array $data = []): View {
		$tName = static::getModelClass()::getTypeName();
		return view("resource.{$tName}.{$action}", $data);
	}

	final protected function tryFetchModel(string $id): Model {
		return $this->model($id) ?? abort(404);
	}

	private static function getModelClass(): string {
		$name = str_replace('Controller', '', class_get_name(static::class));
		return "App\\Models\\{$name}";
	}

	abstract protected function data(?string $query): Collection;

	abstract protected function model(string $id): ?Model;
}
