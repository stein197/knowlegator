<?php

namespace App\Console\Commands;

use App\Console\AbstractSourceMaker;
use Illuminate\Support\Facades\Artisan;
use function strtolower;

final class MakeField extends AbstractSourceMaker {

	protected $signature = 'app:make:field {field}';
	protected $description = 'Create a field';

	public function handle(): int {
		$name = $this->argument('field');
		$result = $this->tryCreate("Fields/{$name}Field.php", <<<PHP
		<?php
		namespace App\Fields;

		use App\Field;

		final class {$name}Field extends Field {}

		PHP);
		if ($result)
			return $result;
		return Artisan::call('make:view', ['name' => 'field.' . strtolower($name)]);
	}
}
