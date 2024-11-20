<?php
namespace App\Console\Commands;

use App\Console\AbstractSourceMaker;

final class MakeService extends AbstractSourceMaker {

	protected $signature = 'app:make:service {service}';
	protected $description = 'Create a service';

	public function handle(): int {
		$service = $this->argument('service');
		return $this->tryCreate("Services/{$service}Service.php", <<<PHP
		<?php
		namespace App\Services;

		final class {$service}Service {

			// TODO
		}

		PHP);
	}
}
