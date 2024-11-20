<?php
namespace App\Console\Commands;

use App\Console\AbstractSourceMaker;

class MakeRecord extends AbstractSourceMaker {

	protected $signature = 'app:make:record {record}';
	protected $description = 'Create a record';

	public function handle(): int {
		$record = $this->argument('record');
		return $this->tryCreate("Records/{$record}Record.php", <<<PHP
		<?php
		namespace App\Records;

		use App\Record;

		final readonly class {$record}Record extends Record {

			public function __construct(
				// TODO
			) {}
		}

		PHP);
	}
}
