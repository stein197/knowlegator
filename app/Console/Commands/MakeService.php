<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use function file_exists;
use function file_put_contents;
use function mkdir;

final class MakeService extends Command {

	public const int CODE_EXISTS = 1;
	public const int CODE_UNKNOWN = 2;

	protected $signature = 'app:make:service {service}';
	protected $description = 'Create a service';

	public function handle(): int {
		$dir = base_path('app/Services');
		$service = $this->argument('service');
		if (!file_exists($dir))
			mkdir($dir);
		$file = base_path("app/Services/{$service}Service.php");
		if (file_exists($file)) {
			$this->error("Service {$file} already exists");
			return self::CODE_EXISTS;
		}
		$content = <<<PHP
		<?php
		namespace App\Services;

		final class {$service}Service {
		
			// TODO
		}
		
		PHP;
		if (file_put_contents($file, $content) === false) {
			$this->error("Cannot write to {$file}");
			return self::CODE_UNKNOWN;
		}
		$this->	info("Service {$file} has been successfully created");
		return 0;
	}
}
