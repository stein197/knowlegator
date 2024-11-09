<?php
namespace App\Enum;

/**
 * Available actions for the login form.
 */
enum LoginAction {

	use EnumUtil;

	case Login;
	case Register;
}
