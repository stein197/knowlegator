<?php
namespace App\Records;

use App\Enum\FormFieldType;
use App\Record;

final readonly class FormFieldRecord extends Record {

	public function __construct(
		/** Field name */
		public string $name = '',
		/** Title to render */
		public ?string $label = null,
		/** Default value */
		public ?string $value = null,
		public FormFieldType $type = FormFieldType::Text,
		/** Tooltip to show */
		public ?string $tooltip = null,
		public bool $required = false
	) {}
}
