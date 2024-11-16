<?php
namespace App\Records;

use App\Record;

final readonly class ButtonRecord extends Record {

	public function __construct(
		public string $label = '',
		public string $type = '',
		public string $name = '',
		public string $value = '',
		public ?string $url = null,
		public ?string $icon = null
	) {}
}
