<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRecord extends Command {

	public const int CODE_EXISTS = 1;
	public const int CODE_UNKNOWN = 2;

	protected $signature = 'app:make:record {record}';
	protected $description = 'Create a record';

	public function handle(): int {
		$dir = base_path('app/Records');
		$record = $this->argument('record');
		if (!file_exists($dir))
			mkdir($dir);
		$file = base_path("app/Records/{$record}Record.php");
		if (file_exists($file)) {
			$this->error("Record {$file} already exists");
			return self::CODE_EXISTS;
		}
		$content = <<<PHP
		<?php
		namespace App\Records;

		use App\Record;

		final readonly class {$record}Record extends Record {
		
			public function __construct(
				// TODO
			) {}
		}
		
		PHP;
		if (file_put_contents($file, $content) === false) {
			$this->error("Cannot write to {$file}");
			return self::CODE_UNKNOWN;
		}
		$this->	info("Record {$file} has been successfully created");
		return 0;
	}
}
