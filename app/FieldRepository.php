<?php
namespace App;

use function array_filter;
use function scandir;
use function str_replace;

final class FieldRepository {

	public function all(): array {
		return array_map(
			fn (string $name): string => '\\App\\Fields\\' . str_replace('.php', '', $name),
			array_filter(
				scandir(app_path('Fields')),
				fn (string $name): bool => $name !== '.' && $name !== '..'
			)
		);
	}
}
