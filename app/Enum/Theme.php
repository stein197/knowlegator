<?php
namespace App\Enum;

enum Theme {

	use FromString;

	case Light;
	case Dark;
}