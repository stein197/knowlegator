<?php
namespace Tests\Feature\Console\Commands;

use App\Console\AbstractSourceMaker;
use Illuminate\Support\Facades\Artisan;
use function file_get_contents;
use function unlink;

afterAll(function (): void {
	@unlink(base_path('app/Fields/TestField.php'));
	@unlink(base_path('resources/views/field/test.blade.php'));
});

test('should throw an exception when field already exists', function (): void {
	/** @var \Tests\TestCase $this */
	$result = Artisan::call('app:make:field', ['field' => 'String']);
	$this->assertSame(AbstractSourceMaker::ERR_EXISTS, $result);
});

test('should create class and view', function (): void {
	/** @var \Tests\TestCase $this */
	Artisan::call('app:make:field', ['field' => 'Test']);
	$path = base_path('app/Fields/TestField.php');
	$this->assertFileExists($path);
	$this->assertSame(<<<PHP
	<?php
	namespace App\Fields;

	use App\Field;

	final class TestField extends Field {}

	PHP, file_get_contents($path));
	$this->assertFileExists(base_path('resources/views/field/test.blade.php'));
});
