<?php
namespace App\Services;

use App\Model;
use Exception;
use Illuminate\Support\Pluralizer;

/**
 * This service class generates URL routes for a given model.
 * @package App\Services
 */
final readonly class ModelRoutingService {

	/**
	 * Generate an URL for the given model or model class and action.
	 * @param string|Model $model Model or a model class to generate an URL for.
	 * @param string $action Action the URL pointing to.
	 * @return ?string Generated URL or `null` if the route doesn't exist.
	 * ```php
	 * $this->route($tagModel, 'edit');   // '/en/account/tags/<id>/edit'
	 * $this->route(Tag::class, 'index'); // '/en/account/tags'
	 * ```
	 */
	public function route(string | Model $model, string $action): ?string {
		$isModel = $model instanceof Model;
		$class = $isModel ? $model::class : $model;
		$tName = $class::getTypeName();
		$plural = Pluralizer::plural($tName);
		try {
			return lroute("{$plural}.{$action}", $isModel ? [$tName => $model->id] : []);
		} catch (Exception) {
			return null;
		}
	}
}
