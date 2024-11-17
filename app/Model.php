<?php
namespace App;

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Pluralizer;
use InvalidArgumentException;
use ReflectionClass;
use function strtolower;

/**
 * Base model class. Provices a convenient way to set `user_id` property.
 * @package App
 */
abstract class Model extends EloquentModel {

	public function __construct(array $attributes = []) {
		if (@$attributes['user']) {
			$attributes['user_id'] = $attributes['user']->id;
			unset($attributes['user']);
		}
		parent::__construct($attributes);
	}

	final public function user(): Attribute {
		return new Attribute(
			get: fn (): User => User::find($this->user_id),
			set: fn (User $u) => [
				'user_id' => $u->id
			]
		);
	}

	/**
	 * Return absolute URL link to this entity based on resource controllers.
	 * @param string $action Resource action, like 'show', 'edit'
	 * @return string URL to the action of the resource.
	 * @throws InvalidArgumentException
	 * @throws BindingResolutionException
	 * ```php
	 * $t = new Tag();
	 * $t->getActionUrl('edit'); // "/en/account/tags/<uuid>/edit"
	 * ```
	 */
	final public function getActionUrl(string $action): string {
		[$singular, $plural] = static::getModelTypeNames();
		return lroute("{$plural}.{$action}", [$singular => $this->id]);
	}

	/**
	 * Return names of publicly available attributes that can be edited or be shown.
	 * @return string[] Publicly available attributes.
	 */
	public static function getPublicAttributes(): array {
		return ['name'];
	}

	private static function getModelTypeNames(): array {
		$class = new ReflectionClass(static::class);
		$name = strtolower($class->getShortName());
		return [$name, Pluralizer::plural($name)];
	}
}
