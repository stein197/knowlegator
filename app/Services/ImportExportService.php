<?php
namespace App\Services;

use App\Models\User;
use App\Serializable;
use Illuminate\Contracts\Auth\Authenticatable;
use ReflectionClass;
use function array_filter;
use function array_map;
use function json_encode;
use function scandir;
use function str_replace;

final class ImportExportService {

	private readonly User $user;

	public function __construct(Authenticatable $user) {
		$this->user = $user;
	}

	public function import(string $data): void {} // TODO

	public function export(User $u): string {
		$result = [];
		foreach (self::models() as $Model)
			$result[$Model::getTypeName()] = $Model::export($this->user);
		return json_encode($result);
	}

	private static function models(): array {
		return array_filter(
				array_map(
				fn (string $name): string => '\\App\\Models\\' . str_replace('.php', '', $name),
				array_filter(
					scandir(app_path('Models')),
					fn (string $name): bool => $name !== '.' && $name !== '..'
				)
			),
			function (string $Model): bool {
				$class = new ReflectionClass($Model);
				$traits = $class->getTraits();
				foreach ($traits as $trait)
					if ($trait->getName() === Serializable::class)
						return true;
				return false;
			}
		);
	}
}
