<?php
namespace App\Records;

final readonly class BreadcrumbRecord {

	public function __construct(
		/** Title to display */
		public string $title = '',
		/** Link to the page */
		public string $link = ''
	) {}
}