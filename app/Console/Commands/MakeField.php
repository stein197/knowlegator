<?php

namespace App\Console\Commands;

use App\Console\AbstractSourceMaker;
use Illuminate\Support\Facades\Artisan;
use function strtolower;

final class MakeField extends AbstractSourceMaker {

	protected $signature = 'app:make:field {field}';
	protected $description = 'Create a field and a view for it';

	public function handle(): int {
		$name = $this->argument('field');
		$result = $this->tryCreate("app/Fields/{$name}Field.php", <<<PHP
		<?php
		namespace App\Fields;

		use App\Field;

		final class {$name}Field extends Field {}

		PHP);
		if ($result)
			return $result;
		$result = $this->tryCreate("tests/Feature/Fields/{$name}FieldTest.php", <<<PHP
		<?php
		namespace Tests\Feature\Fields;

		describe('view()', function (): void {
			test('should work', function (): void {
				/** @var \Tests\TestCase \$this */
				// TODO
			});
		});

		PHP);
		if ($result)
			return $result;
		return Artisan::call('make:view', ['name' => 'field.' . strtolower($name)], $this->output);
	}
}
