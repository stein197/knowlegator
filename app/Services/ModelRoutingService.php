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
	 * Generate an URL for the given model and action.
	 * @param Model $model Model to generate an URL for.
	 * @param string $action Action the URL pointing to.
	 * @return ?string Generated URL or `null` if the route doesn't exist.
	 * ```php
	 * $this->route($tagModel, 'edit'); // '/en/tags/<id>/edit'
	 * ```
	 */
	public function route(Model $model, string $action): ?string {
		$tName = $model::class::getTypeName();
		$plural = Pluralizer::plural($tName);
		try {
			return lroute("{$plural}.{$action}", [$tName => $model->id]);
		} catch (Exception) {
			return null;
		}
	}
}
