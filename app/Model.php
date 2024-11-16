<?php
namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use function App\array_unset;

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
	 * Return publicly available properties that can be edited or be shown.
	 * @return array Publicly available attributes.
	 */
	final public function getPublicAttributes(): array {
		return array_unset($this->attributes, [
			'id', 'user_id', 'created_at', 'updated_at'
		]);
	}
}
