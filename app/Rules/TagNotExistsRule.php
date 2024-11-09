<?php
namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TagNotExistsRule implements ValidationRule {

	public function __construct(
		private readonly User $user
	) {}

	public function validate(string $attribute, mixed $value, Closure $fail): void {
		$exists = $this->user->findTagByName($value) !== null;
		if ($exists)
			$fail('rule.userTagNotExists')->translate(['tag' => $value]);
	}
}
