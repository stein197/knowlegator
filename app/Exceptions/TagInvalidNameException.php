<?php
namespace App\Exceptions;

use Exception;

/**
 * The exception is thrown when the name is invalid.
 * @package App\Exceptions
 */
class TagInvalidNameException extends Exception {

	/** When the name is empty */
	public const int REASON_EMPTY = 1;

	/** When then name does not complain the given regex */
	public const int REASON_INVALID = 2;
}
