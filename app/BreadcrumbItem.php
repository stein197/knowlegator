<?php
namespace App;

final readonly class BreadcrumbItem {

	public function __construct(
		public string $title = '',
		public string $link = ''
	) {}
}