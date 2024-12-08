<?php
namespace App\Models;

use App\Exceptions\TagInvalidNameException;
use App\Model;
use App\ModelAccessors\UserAccessor;
use App\Serializable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use function array_map;
use function preg_match;

class Tag extends Model {

	use HasFactory;
	use HasUuids;
	use UserAccessor;
	use Serializable;

	public const string NAME_REGEX = '/^[[:alnum:]_-]+$/';

	protected $fillable = [
		'name',
		'user_id'
	];

	protected function name(): Attribute {
		return new Attribute(
			set: function (string $value): string {
				if (!$value)
					throw new TagInvalidNameException('Name is invalid', TagInvalidNameException::REASON_EMPTY);
				if (!preg_match(static::NAME_REGEX, $value))
					throw new TagInvalidNameException("Name '{$this->name}' contains invalid characters. The name should complain the given regex: " . static::NAME_REGEX, TagInvalidNameException::REASON_INVALID);
				return $value;
			}
		);
	}

	public static function export(User $u): array {
		return array_map(
			function (self $tag): array {
				$attributes = $tag->toArray();
				unset($attributes['user_id']);
				return $attributes;
			},
			[...static::all()->where('user_id', $u->id)]
		);
	}
}
