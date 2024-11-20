<?php
namespace App\Console;

use Illuminate\Console\Command;
use function file_exists;
use function file_put_contents;

abstract class AbstractSourceMaker extends Command {

	public const int ERR_EXISTS = 1;
	public const int ERR_UNKNOWN = 2;

	final public function tryCreate(string $path, string $content): int {
		$path = app_path($path);
		if (file_exists($path)) {
			$this->error("File {$path} already exists");
			return self::ERR_EXISTS;
		}
		if (file_put_contents($path, $content) === false) {
			$this->error("Cannot write to {$path}");
			return self::ERR_UNKNOWN;
		}
		$this->info("File {$path} has been successfully created");
		return 0;
	}
}
