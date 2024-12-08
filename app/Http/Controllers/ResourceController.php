<?php
namespace App\Http\Controllers;

use App\Enum\Http\Method;
use App\Form;
use App\Model;
use App\View\Components\Button;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Pluralizer;
use ReflectionClass;
use function App\array_entries;
use function array_map;
use function explode;
use function is_string;
use function join;
use function preg_replace;
use function strtolower;

abstract class ResourceController extends Controller {

	public function index(): View {
		$q = $this->request->query('q');
		$tName = static::getModelTypeName(true);
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
					href: $this->getActionUrl('create'),
					icon: 'plus-lg'
				)
			]
		]);
	}

	public function create(): View {
		$tName = static::getModelTypeName(true);
		return $this->view('create', [
			'title' => __("resource.{$tName}.create.title"),
			'form' => $this->form(Method::POST, null)
		]);
	}

	public function edit(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelTypeName(true);
		return $this->view('edit', [
			'title' => join(' / ', [__("resource.{$tName}.index.title"), __('action.edit'), $model->name]),
			'model' => $model,
			'alert' => $this->request->session()->get('alert'),
			'form' => $this->form(Method::PUT, $model, )
		]);
	}

	public function show(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelTypeName(true);
		return $this->view('show', [
			'title' => __("resource.{$tName}.index.title") . ' / ' . $model->name,
			'model' => $model,
			'buttons' => [
				new Button(
					label: __('action.back'),
					variant: 'outline-secondary color-inherit',
					href: $this->getActionUrl('index')
				),
				new Button(
					label: __('action.edit'),
					variant: 'outline-secondary color-inherit',
					icon: 'pen-fill',
					href: $this->getActionUrl('edit', [$tName => $model->id])
				),
				new Button(
					label: __('action.delete'),
					variant: 'outline-secondary color-inherit',
					icon: 'trash-fill',
					href: $this->getActionUrl('delete', [$tName => $model->id])
				)
			]
		]);
	}

	public function delete(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelTypeName(true);
		return $this->view('delete', [
			'title' => join(' / ', [__("resource.{$tName}.index.title"), __('action.delete'), $model->name]),
			'model' => $model,
			'form' => new Form(
				action: $this->getActionUrl('destroy', [$tName => $model->id]),
				method: Method::DELETE,
				alert: [
					'type' => 'danger',
					'message' => __("resource.{$tName}.delete.confirmation", ['name' => $model->name])
				],
				buttons: [
					new Button(
						label: __('action.cancel'),
						variant: 'warning',
						href: $this->getActionUrl('show', [$tName => $model->id])
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
		$tName = static::getModelTypeName(true);
		$routePrefix = Pluralizer::plural($tName);
		$result = $model->forceDelete();
		return $this->redirect("{$routePrefix}.index")->with('alert', [
			'message' => __($result ? "message.{$tName}.deleted" : "message.{$tName}.cannotDelete", ['name' => $model->name]),
			'type' => $result ? 'success' : 'danger',
			'dismissible' => true
		]);
	}

	final protected function view(string $action, array $data = []): View {
		$tName = static::getModelTypeName(true);
		return view("resource.{$tName}.{$action}", $data);
	}

	final protected function tryFetchModel(string $id): Model {
		return $this->model($id) ?? abort(404);
	}

	private function getActionUrl(string $action, array $parameters = []): string {
		[$model] = explode('.', $this->request->route()->getName());
		return lroute($model . '.' . $action, $parameters);
	}

	private function form(Method $method, ?Model $model): Form {
		$tName = static::getModelTypeName(true);
		return new Form(
			action: $this->getActionUrl($method === Method::PUT ? 'update' : 'store', [$tName => $model?->id]),
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
					href: $this->getActionUrl('show', [$tName => $model->id])
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
					href: $this->getActionUrl('index')
				),
				new Button(
					label: __('action.save'),
					variant: 'success',
					type: 'submit'
				)
			]
		);
	}

	private static function getModelTypeName(bool $lc): string {
		$class = new ReflectionClass(static::class);
		$tName = preg_replace('/Controller$/', '', $class->getShortName());
		return $lc ? strtolower($tName) : $tName;
	}

	private static function getModelClass(): string {
		$tName = static::getModelTypeName(false);
		return "App\\Models\\{$tName}";
	}

	abstract protected function data(?string $query): Collection;

	abstract protected function model(string $id): ?Model;
}
