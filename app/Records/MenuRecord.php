<?php
namespace App\Records;

use App\Record;

/**
 * Represent a single menu item.
 * @package App
 */
final readonly class MenuRecord extends Record {

	public function __construct(
		/** Title to show */
		public string $title = '',
		/** URL link */
		public string $link = '',
		/** `true` if the current route equals to this route */
		public bool $active = false,
		/** Bootstrap icon class */
		public string $icon = ''
	) {}
}
