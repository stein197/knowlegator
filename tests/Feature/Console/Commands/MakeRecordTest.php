<?php
namespace Tests\Feature\Console\Commands;

use App\Console\Commands\MakeRecord;
use Illuminate\Support\Facades\Artisan;
use function file_get_contents;
use function unlink;

afterAll(function (): void {
	@unlink(base_path('app/Records/TestRecord.php'));
});

test('should throw an exception when record already exists', function (): void {
	/** @var \Tests\TestCase $this */
	$result = Artisan::call('app:make:record', ['record' => 'Menu']);
	$this->assertSame(MakeRecord::CODE_EXISTS, $result);
});

test('should create a service', function (): void {
	/** @var \Tests\TestCase $this */
	Artisan::call('app:make:record', ['record' => 'Test']);
	$path = base_path('app/Records/TestRecord.php');
	$this->assertFileExists($path);
	$this->assertSame(<<<PHP
	<?php
	namespace App\Records;

	use App\Record;

	final readonly class TestRecord extends Record {

		public function __construct(
			// TODO
		) {}
	}

	PHP, file_get_contents($path));
});
