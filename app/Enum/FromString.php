<?php
namespace App\Enum;

use function strcasecmp;

/**
 * Trait to be used by enums that adds a method `from()`.
 */
trait FromString {

	/**
	 * Returns a case that matches the given string. The comparison performs in case-insensetive mode.
	 * @param string $name Name of the case.
	 * @return null|static Case if the matching was successful or nul otherwise.
	 * ```php
	 * enum TestEnum {
	 * 
	 * 	use FromString;
	 * 
	 * 	case FirstCase;
	 * }
	 * 
	 * TestEnum::from('firstcase'); // TestEnum::FirstCase
	 * ```
	 */
	public static function from(string $name): ?static {
		foreach (static::cases() as $case)
			if (strcasecmp($name, $case->name) === 0)
				return $case;
		return null;
	}
}
