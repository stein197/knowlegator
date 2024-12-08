<?php
namespace App;

use App\Models\User;

trait Serializable {

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
