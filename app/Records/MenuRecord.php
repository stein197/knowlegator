<?php
namespace App\Records;

/**
 * Represent a single menu item.
 * @package App
 */
final readonly class MenuRecord {

	public function __construct(
		/** Title to show */
		public string $title = '',
		/** URL link */
		public string $link = '',
		/** Route name */
		public string $routeName = '',
		/** `true` if the current route equals to this route */
		public bool $active = false
	) {}
}
