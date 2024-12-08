<?php
namespace App;

use App\Models\User;

trait Serializable {

	abstract public static function export(User $u): array;
}
