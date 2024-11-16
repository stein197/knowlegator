<?php
namespace App\Http\Controllers;

use App\Records\ButtonRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use ReflectionClass;
use function explode;
use function is_string;
use function preg_replace;
use function strtolower;

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

	final protected function view(string $action, array $data = []): View {
		$name = static::getModelName();
		return view("resource.{$name}.{$action}", $data);
	}

	final private function getActionUrl(string $action): string {
		[$model] = explode('.', $this->request->route()->getName());
		return lroute($model . '.' . $action);
	}

	final private static function getModelName(): string {
		$class = new ReflectionClass(static::class);
		$name = preg_replace('/Controller$/', '', $class->getShortName());
		return strtolower($name);
	}

	abstract protected function data(?string $query): Collection;
}
