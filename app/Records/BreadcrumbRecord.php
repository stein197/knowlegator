<?php
namespace App\Records;

use App\Record;

final readonly class BreadcrumbRecord extends Record {

	public function __construct(
		/** Title to display */
		public string $title = '',
		/** Link to the page */
		public string $link = ''
	) {}
}