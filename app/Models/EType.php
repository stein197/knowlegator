<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Entity type.
 * @package App\Models
 */
class EType extends Model {

	use HasFactory;
	use HasUuids;

	protected $table = 'etypes';
	protected $fillable = [
		'name',
		'user_id'
	];

	// TODO: Extract to BaseModel class
	public function __construct(array $attributes = []) {
		if (@$attributes['user']) {
			$attributes['user_id'] = $attributes['user']->id;
			unset($attributes['user']);
		}
		parent::__construct($attributes);
	}

	public function user(): Attribute {
		return new Attribute(
			get: fn (): User => User::find($this->user_id),
			set: fn (User $u) => [
				'user_id' => $u->id
			]
		);
	}
}
