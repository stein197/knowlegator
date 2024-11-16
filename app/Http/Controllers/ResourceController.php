<?php
namespace App\Http\Controllers;

use App\Model;
use App\Records\ButtonRecord;
use App\Records\FormFieldRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use ReflectionClass;
use function array_map;
use function explode;
use function is_string;
use function preg_replace;
use function strtolower;
use function App\array_entries;

abstract class ResourceController extends Controller {

	public function __construct(
		protected readonly Request $request
	) {}

	public function index(): View {
		$q = $this->request->query('q');
		$name = static::getModelName();
		if (!is_string($q))
			$q = null;
		$data = $this->data($q);
		return $this->view('index', [
			'title' => __("resource.{$name}.index.title"),
			'data' => $data,
			'search' => [
				'action' => '/' . $this->request->path(),
				'placeholder' => __("resource.{$name}.index.search-placeholder"),
				'value' => $q,
			],
			'alert' => $data->isEmpty() ? ($q === null ? __("resource.{$name}.index.message.empty") : __("resource.{$name}.index.message.emptySearchResult")) : null,
			'action' => [
				new ButtonRecord(
					label: __("resource.{$name}.create.title"),
					type: 'primary',
					url: $this->getActionUrl('create')
				)
			]
		]);
	}

	public function edit(string $locale, string $id): View {
		$model = $this->tryGetModel($id);
		$name = static::getModelName();
		return $this->view('edit', [
			'title' => __("resource.{$name}.index.title") . ' / ' . __('action.edit') . ' / ' . $model->name,
			'model' => $model,
			'action' => $this->getActionUrl('update', [$name => $model->id]),
			'fields' => array_map(
				fn (array $entry) => new FormFieldRecord(
					name: $entry[0],
					value: $entry[1]
				),
				array_entries($model->getPublicAttributes())
			),
			'actions' => [
				new ButtonRecord(
					label: __('action.cancel'),
					type: 'warning',
					url: $this->getActionUrl('show', [$name => $model->id])
				),
				new ButtonRecord(
					label: __('action.save'),
					type: 'success'
				)
			],
		]);
	}

	public function show(string $locale, string $id): View {
		$model = $this->tryGetModel($id);
		$name = static::getModelName();
		return $this->view('show', [
			'title' => __("resource.{$name}.index.title") . ' / ' . $model->name,
			'model' => $model,
			'buttons' => [
				new ButtonRecord(
					label: __('action.edit'),
					type: 'primary',
					icon: 'pen-fill',
					url: $this->getActionUrl('edit', [$name => $model->id])
				),
				new ButtonRecord(
					label: __('action.delete'),
					type: 'danger',
					icon: 'trash-fill',
					url: $this->getActionUrl('delete', [$name => $model->id])
				)
			]
		]);
	}

	public function delete(string $locale, string $id): View {
		$model = $this->tryGetModel($id);
		$name = static::getModelName();
		return $this->view('delete', [
			'title' => __("resource.{$name}.index.title") . ' / ' . __('action.delete') . ' / ' . $model->name,
			'model' => $model,
			'message' => __("resource.{$name}.delete.confirmation", ['name' => $model->name]),
			'action' => $this->getActionUrl('destroy', [$name => $model->id]),
		]);
	}

	final protected function view(string $action, array $data = []): View {
		$name = static::getModelName();
		return view("resource.{$name}.{$action}", $data);
	}

	final protected function tryGetModel(string $id): Model {
		return $this->model($id) ?? abort(404);
	}

	private function getActionUrl(string $action, array $parameters = []): string {
		[$model] = explode('.', $this->request->route()->getName());
		return lroute($model . '.' . $action, $parameters);
	}

	private static function getModelName(): string {
		$class = new ReflectionClass(static::class);
		$name = preg_replace('/Controller$/', '', $class->getShortName());
		return strtolower($name);
	}

	abstract protected function data(?string $query): Collection;

	abstract protected function model(string $id): ?Model;
}
