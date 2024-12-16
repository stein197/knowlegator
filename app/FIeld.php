<?php
namespace App;

use Illuminate\View\View;
use function preg_replace;
use function strtolower;

abstract class Field {

	protected const array PARAMS_DEFAULT = [];

	public readonly array $params;

	public function __construct(
		public readonly string $label,
		public readonly string $name,
		public ?string $value = null,
		public readonly bool $readonly = false,
		public readonly bool $required = false,
		array $params = [],
		public readonly null | string | array $validate = null
	) {
		$this->params = [...static::PARAMS_DEFAULT, ...$params];
	}

	final public function view(array $parameters = []): View {
		$tName = static::getTypeName();
		return view("field.{$tName}", ['f' => $this, ...$parameters]);
	}

	public static function getTypeName(): string {
		$classname = class_get_name(static::class);
		return preg_replace('/field$/', '', strtolower($classname));
	}
}
