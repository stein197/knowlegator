<?php
namespace App\ModelAccessors;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait UserAccessor {

	final public function user(): Attribute {
		return new Attribute(
			get: fn (): User => User::find($this->user_id),
			set: fn (User $u) => [
				'user_id' => $u->id
			]
		);
	}
}
