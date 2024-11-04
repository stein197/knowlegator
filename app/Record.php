<?php
namespace App;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

// TODO: Extract to a library
/**
 * Base class for records.
 * @package App
 */
abstract readonly class Record {

	/**
	 * Check if the given argument equals to this record.
	 * @param mixed $record Object to test against.
	 * @return bool `true` if both records are equal.
	 * ```php
	 * (new Record())->equals(new Record()); // true
	 * ```
	 */
	public final function equals(mixed $record): bool {
		return $record === $this || $record instanceof static && $this->toArray() === $record->toArray();
	}

	/**
	 * Clone the record with the given properties to override.
	 * @param array $properties Properties to override.
	 * @return static New record.
	 * @throws ReflectionException
	 * ```php
	 * (new Record(...))->with(['property' => 'value']);
	 * ```
	 */
	public final function with(array $properties): static {
		return static::fromArray($properties);
	}

	/**
	 * Convert the record to an array. The opposite of `fromArray()`.
	 * @return array Array with the properties of a record.
	 * ```php
	 * (new Record(a: 'first'))->toArray(); // ['a' => 'first']
	 * ```
	 */
	public final function toArray(): array {
		$parameters = static::parameters();
		$result = [];
		foreach ($parameters as $p)
			$result[$p->name] = $this->{$p->name};
		return $result;
	}

	/**
	 * Convert an array to a record. The opposite of `toArray()`.
	 * @param array $properties Properties that the record should have. Properties without values will have a default value.
	 * @return static Record
	 * @throws ReflectionException
	 * ```php
	 * Record::fromArray(['a' => 'first']); // Record {a: 'first'}
	 * ```
	 */
	public final static function fromArray(array $properties): static {
		$parameters = static::parameters();
		$result = [];
		foreach ($parameters as $p)
			$result[] = isset($properties[$p->name]) ? $properties[$p->name] : $p->getDefaultValue();
		return new static(...$result);
	}

	/**
	 * @return ReflectionParameter[]
	 */
	private static function parameters(): array {
		static $cache = [];
		if (!$cache)
			$cache = (new ReflectionClass(static::class))->getConstructor()->getParameters();
		return $cache;
	}
}
