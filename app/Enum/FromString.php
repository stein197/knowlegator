<?php
namespace App\Enum;

use function array_map;
use function strcasecmp;
use function strtolower;

// TODO: Rename
/**
 * Trait to be used by enums that adds methods `from()` and `names()`.
 */
trait FromString {

	/**
	 * Return lowercased case name.
	 * @return string Lowercased name.
	 * ```php
	 * TestEnum::FirstCase->name(); // 'firstcase'
	 * ```
	 */
	public function name(): string {
		return strtolower($this->name);
	}

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

	/**
	 * Return case names array.
	 * @param bool $lcase Return names in lowercase when `true`.
	 * @return string[] Names of cases.
	 * ```
	 * enum TestEnum {
	 * 	use FromString;
	 *
	 * 	case First;
	 * 	case Second;
	 * }
	 * TestEnum::names(true); // ['first', 'second']
	 * ```
	 */
	public static function names(bool $lcase = true): array {
		return array_map(
			fn (self $case): string => $lcase ? strtolower($case->name) : $case->name,
			static::cases()
		);
	}
}
