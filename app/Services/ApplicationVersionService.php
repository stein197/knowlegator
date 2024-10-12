<?php
namespace App\Services;

use function file_get_contents;
use function json_decode;

/**
 * Provide an information about the application version.
 * @package App\Services
 */
final class ApplicationVersionService {

	private array $cache = [];

	/**
	 * Return an information about client version that's read from the `package.json` file.
	 * @return string Client version.
	 */
	public function getClientVersion(): string {
		return $this->getVersion('package.json');
	}

	/**
	 * Return an information about server version that's read from the `composer.json` file.
	 * @return string Server version.
	 */
	public function getServerVersion(): string {
		return $this->getVersion('composer.json');
	}

	private function getVersion(string $file): string {
		if (!isset($this->cache[$file])) {
			$path = base_path($file);
			$contents = file_get_contents($path);
			$json = json_decode($contents);
			$this->cache[$file] = $json->version;
		}
		return $this->cache[$file];
	}
}
