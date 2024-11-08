<?php
namespace App\Records;

use App\Enum\FormFieldType;
use App\Record;

final readonly class FormFieldRecord extends Record {

	public function __construct(
		/** Field name */
		public string $name = '',
		/** Title to render */
		public string $label = '',
		/** Default value */
		public ?string $value = null,
		public FormFieldType $type = FormFieldType::Text,
		public bool $required = false
	) {}
}
