<?php
namespace App\Enum;

enum FormFieldType {

	use FromString;

	case Text;
	case Password;
	case EMail;
	case Checkbox;
}
