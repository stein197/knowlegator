<?php
namespace App\Enum;

/**
 * Available actions for the login form.
 */
enum LoginAction {

	use FromString;

	case Login;
	case Register;
}
