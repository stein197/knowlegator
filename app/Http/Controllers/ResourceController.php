<?php
namespace App\Http\Controllers;

use App\Enum\Http\Method;
use App\Form;
use App\Model;
use App\Models\User;
use App\Records\ButtonRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use ReflectionClass;
use function App\array_entries;
use function array_map;
use function explode;
use function is_string;
use function join;
use function preg_replace;
use function strtolower;

abstract class ResourceController extends Controller {

	protected readonly User $user;

	public function __construct(
		protected readonly Request $request
	) {
		$this->user = $request->user();
	}

	public function index(): View {
		$q = $this->request->query('q');
		$tName = static::getModelTypeName(true);
		if (!is_string($q))
			$q = null;
		$data = $this->data($q);
		return $this->view('index', [
			'title' => __("resource.{$tName}.index.title"),
			'data' => $data,
			'search' => [
				'action' => '/' . $this->request->path(),
				'placeholder' => __("resource.{$tName}.index.search-placeholder"),
				'value' => $q,
			],
			'alert' => $data->isEmpty() ? ($q === null ? __("resource.{$tName}.index.message.empty") : __("resource.{$tName}.index.message.emptySearchResult")) : null,
			'action' => [
				new ButtonRecord(
					label: __("resource.{$tName}.create.title"),
					type: 'primary',
					url: $this->getActionUrl('create')
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
			'form' => $this->form(Method::PUT, $model)
		]);
	}

	public function show(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelTypeName(true);
		return $this->view('show', [
			'title' => __("resource.{$tName}.index.title") . ' / ' . $model->name,
			'model' => $model,
			'buttons' => [
				new ButtonRecord(
					label: __('back'),
					url: $this->getActionUrl('index')
				),
				new ButtonRecord(
					label: __('action.edit'),
					icon: 'pen-fill',
					url: $this->getActionUrl('edit', [$tName => $model->id])
				),
				new ButtonRecord(
					label: __('action.delete'),
					icon: 'trash-fill',
					url: $this->getActionUrl('delete', [$tName => $model->id])
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
			'message' => __("resource.{$tName}.delete.confirmation", ['name' => $model->name]),
			'form' => new Form(
				action: $this->getActionUrl('destroy', [$tName => $model->id]),
				method: Method::DELETE,
				buttons: [
					new ButtonRecord(
						label: __('action.cancel'),
						type: 'warning',
						url: $this->getActionUrl('show', [$tName => $model->id])
					),
					new ButtonRecord(
						label: __('action.delete'),
						type: 'danger'
					)
				]
			)
		]);
	}

	public function destroy(string $locale, string $id): View {
		$model = $this->tryFetchModel($id);
		$tName = static::getModelTypeName(true);
		$result = $model->forceDelete();
		return view('page.message', [
			'title' => __("resource.{$tName}.delete.title"),
			'message' => __($result ? "message.{$tName}.deleted" : "message.{$tName}.cannotDelete", ['name' => $model->name]),
			'type' => $result ? 'success' : 'danger'
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
			fields: array_map(
				fn (array $entry) => new $entry[1](
					label: $entry[0],
					name: $entry[0],
					value: $model?->{$entry[0]}
				),
				array_entries(static::getModelClass()::getPublicAttributes())
			),
			buttons: $method === Method::PUT ? [
				new ButtonRecord(
					label: __('action.cancel'),
					type: 'warning',
					url: $this->getActionUrl('show', [$tName => $model->id])
				),
				new ButtonRecord(
					label: __('action.save'),
					type: 'success'
				)
			] : [
				new ButtonRecord(
					label: __('action.cancel'),
					type: 'warning',
					url: $this->getActionUrl('index')
				),
				new ButtonRecord(
					label: __('action.save'),
					type: 'success'
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
