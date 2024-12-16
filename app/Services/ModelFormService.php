<?php
namespace App\Services;

use App\Enum\Http\Method;
use App\Form;
use App\Model;
use App\View\Components\Button;
use function App\array_entries;
use function array_map;

/**
 * The service is responsive for automatizing the process of creating of HTML forms for the givem model or model class.
 * @package App\Services
 */
final readonly class ModelFormService {

	public function __construct(
		private ModelRoutingService $routing
	) {}

	public function form(string | Model $modelOrClass, string $action): Form {
		return new Form(
			action: $action === 'show' ? '' : $this->routing->route($modelOrClass, $action),
			alert: $this->getAlert($modelOrClass, $action),
			method: $this->getMethod($action),
			fields: $this->getFields($modelOrClass, $action),
			buttons: $this->getButtons($modelOrClass, $action),
			readonly: $action === 'show',
			groupButtons: $action === 'show'
		);
	}

	private function getAlert(string | Model $modelOrClass, string $action): ?array {
		[$model, $class] = self::getModelAndClass($modelOrClass);
		return match ($action) {
			'destroy' => [
				'type' => 'danger',
				'message' => __('resource.' . $class::getTypeName() . '.delete.confirmation', ['name' => $model->name])
			],
			default => session()->get('alert')
		};
	}

	private function getMethod(string $action): Method {
		return match ($action) {
			'store' => Method::POST,
			'update' => Method::PUT,
			'destroy' => Method::DELETE,
			default => Method::GET
		};
	}

	private function getFields(string | Model $modelOrClass, string $action): array {
		[$model, $class] = self::getModelAndClass($modelOrClass);
		return match ($action) {
			'destroy' => [],
			default => array_map(
				fn (array $entry) => new $entry[1](
					label: $entry[0],
					name: $entry[0],
					value: $model?->{$entry[0]}
				),
				array_entries($class::getPublicAttributes())
			)
		};
	}

	private function getButtons(string | Model $modelOrClass, string $action): array {
		return match ($action) {
			'show' => [
				new Button(
					label: __('action.back'),
					variant: 'outline-secondary color-inherit',
					href: $this->routing->route($modelOrClass, 'index')
				),
				new Button(
					label: __('action.edit'),
					variant: 'outline-secondary color-inherit',
					icon: 'pen-fill',
					href: $this->routing->route($modelOrClass, 'edit')
				),
				new Button(
					label: __('action.delete'),
					variant: 'outline-secondary color-inherit',
					icon: 'trash-fill',
					href: $this->routing->route($modelOrClass, 'delete')
				)
			],
			'store' => [
				new Button(
					label: __('action.cancel'),
					variant: 'warning',
					href: $this->routing->route($modelOrClass, 'index')
				),
				new Button(
					label: __('action.save'),
					variant: 'success',
					type: 'submit'
				)
			],
			'update' => [
				new Button(
					label: __('action.cancel'),
					variant: 'warning',
					href: $this->routing->route($modelOrClass, 'show')
				),
				new Button(
					label: __('action.save'),
					variant: 'success',
					type: 'submit'
				)
			],
			'destroy' => [
				new Button(
					label: __('action.cancel'),
					variant: 'warning',
					href: $this->routing->route($modelOrClass, 'show')
				),
				new Button(
					label: __('action.delete'),
					variant: 'danger',
					type: 'submit'
				)
			],
			default => []
		};
	}

	private static function getModelAndClass(string | Model $modelOrClass): array {
		return $modelOrClass instanceof Model ? [$modelOrClass, $modelOrClass::class] : [null, $modelOrClass];
	}
}
