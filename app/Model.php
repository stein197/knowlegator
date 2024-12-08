<?php
namespace App;

use App\Fields\StringField;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Pluralizer;
use InvalidArgumentException;
use ReflectionClass;
use function strtolower;

abstract class Model extends EloquentModel {

	/**
	 * Create a new model.
	 * @param array $attributes Attributes. Can contain instances of the `Model` class.
	 * @return void
	 * @throws MassAssignmentException
	 */
	public function __construct(array $attributes = []) {
		foreach ($attributes as $k => $v) {
			if (!$v instanceof EloquentModel)
				continue;
			$attributes["{$k}_id"] = $v->id;
			unset($attributes[$k]);
		}
		parent::__construct($attributes);
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
		$tName = static::getTypeName();
		$plural = Pluralizer::plural($tName);
		return lroute("{$plural}.{$action}", [$tName => $this->id]);
	}

	/**
	 * Return names of publicly available attributes that can be edited or be shown. Key is a column name and value is
	 * a field classname to be used.
	 * @return array Publicly available attributes.
	 */
	public static function getPublicAttributes(): array {
		return ['name' => StringField::class];
	}

	/**
	 * Return model type name in lowercase.
	 * @return string Type name.
	 * ```php
	 * User::getTypeName(); // 'user'
	 * Tag::getTypeName();  // 'tag'
	 * ```
	 */
	final public static function getTypeName(): string {
		$class = new ReflectionClass(static::class);
		return strtolower($class->getShortName());
	}
}
