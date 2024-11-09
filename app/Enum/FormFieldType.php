<?php
namespace App\Enum;

enum FormFieldType {

	use EnumUtil;

	case Text;
	case Password;
	case EMail;
	case Checkbox;
}
