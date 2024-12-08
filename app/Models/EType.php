<?php
namespace App\Models;

use App\Fields\StringField;
use App\Fields\TextareaField;
use App\Model;
use App\ModelAccessors\UserAccessor;
use App\Serializable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Entity type.
 * @package App\Models
 */
class EType extends Model {

	use HasFactory;
	use HasUuids;
	use UserAccessor;
	use Serializable;

	protected $table = 'etypes';
	protected $fillable = [
		'name',
		'description',
		'user_id'
	];

	public static function getPublicAttributes(): array {
		return [
			'name' => StringField::class,
			'description' => TextareaField::class
		];
	}

	public static function export(User $u): array {
		return array_map(
			function (self $etype): array {
				$attributes = $etype->toArray();
				unset($attributes['user_id']);
				return $attributes;
			},
			[...static::all()->where('user_id', $u->id)]
		);
	}
}
