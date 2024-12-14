<?php
namespace App\Http\Controllers;

use App\Enum\Http\Method;
use App\Form;
use App\Model;
use App\Services\ModelRoutingService;
use App\View\Components\Button;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Pluralizer;
use function App\array_entries;
use function App\class_get_name;
use function array_map;
use function is_string;
use function join;
use function str_replace;

abstract class ResourceController extends Controller {

	public function __construct(
		Request $request,
		protected readonly ModelRoutingService $modelRoutingService
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
		$tName = static::getModelClass()::getTypeName();
		return $this->view('create', [
			'title' => __("resource.{$tName}.create.title"),
			'form' => $this->form(Method::POST, null)
		]);
	}

	public function edit(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelClass()::getTypeName();
		return $this->view('edit', [
			'title' => join(' / ', [__("resource.{$tName}.index.title"), __('action.edit'), $model->name]),
			'model' => $model,
			'alert' => $this->request->session()->get('alert'),
			'form' => $this->form(Method::PUT, $model, )
		]);
	}

	public function show(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelClass()::getTypeName();
		return $this->view('show', [
			'title' => __("resource.{$tName}.index.title") . ' / ' . $model->name,
			'model' => $model,
			'buttons' => [
				new Button(
					label: __('action.back'),
					variant: 'outline-secondary color-inherit',
					href: $this->modelRoutingService->route(static::getModelClass(), 'index')
				),
				new Button(
					label: __('action.edit'),
					variant: 'outline-secondary color-inherit',
					icon: 'pen-fill',
					href: $this->modelRoutingService->route($model, 'edit')
				),
				new Button(
					label: __('action.delete'),
					variant: 'outline-secondary color-inherit',
					icon: 'trash-fill',
					href: $this->modelRoutingService->route($model, 'delete')
				)
			]
		]);
	}

	public function delete(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelClass()::getTypeName();
		return $this->view('delete', [
			'title' => join(' / ', [__("resource.{$tName}.index.title"), __('action.delete'), $model->name]),
			'model' => $model,
			'form' => new Form(
				action: $this->modelRoutingService->route($model, 'destroy'),
				method: Method::DELETE,
				alert: [
					'type' => 'danger',
					'message' => __("resource.{$tName}.delete.confirmation", ['name' => $model->name])
				],
				buttons: [
					new Button(
						label: __('action.cancel'),
						variant: 'warning',
						href: $this->modelRoutingService->route($model, 'show')
					),
					new Button(
						label: __('action.delete'),
						variant: 'danger',
						type: 'submit'
					)
				]
			)
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

	private function form(Method $method, ?Model $model): Form {
		return new Form(
			action: $method === Method::PUT ? $this->modelRoutingService->route($model, 'update') : $this->modelRoutingService->route(static::getModelClass(), 'store'),
			method: $method,
			alert: session()->get('alert'),
			fields: array_map(
				fn (array $entry) => new $entry[1](
					label: $entry[0],
					name: $entry[0],
					value: $model?->{$entry[0]}
				),
				array_entries(static::getModelClass()::getPublicAttributes())
			),
			buttons: $method === Method::PUT ? [
				new Button(
					label: __('action.cancel'),
					variant: 'warning',
					href: $this->modelRoutingService->route($model, 'show')
				),
				new Button(
					label: __('action.save'),
					variant: 'success',
					type: 'submit'
				)
			] : [
				new Button(
					label: __('action.cancel'),
					variant: 'warning',
					href: $this->modelRoutingService->route(static::getModelClass(), 'index')
				),
				new Button(
					label: __('action.save'),
					variant: 'success',
					type: 'submit'
				)
			]
		);
	}

	private static function getModelClass(): string {
		$name = str_replace('Controller', '', class_get_name(static::class));
		return "App\\Models\\{$name}";
	}

	abstract protected function data(?string $query): Collection;

	abstract protected function model(string $id): ?Model;
}
