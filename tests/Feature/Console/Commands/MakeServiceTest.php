<?php
namespace Tests\Feature\Console\Commands;

use App\Console\AbstractSourceMaker;
use Illuminate\Support\Facades\Artisan;
use function file_get_contents;
use function unlink;

afterAll(function (): void {
	@unlink(base_path('app/Services/TestService.php'));
});

test('should throw an exception when service already exists', function (): void {
	/** @var \Tests\TestCase $this */
	$result = Artisan::call('app:make:service', ['service' => 'Theme']);
	$this->assertSame(AbstractSourceMaker::ERR_EXISTS, $result);
});

test('should create a service', function (): void {
	/** @var \Tests\TestCase $this */
	Artisan::call('app:make:service', ['service' => 'Test']);
	$path = base_path('app/Services/TestService.php');
	$this->assertFileExists($path);
	$this->assertSame(<<<PHP
	<?php
	namespace App\Services;

	final class TestService {

		// TODO
	}

	PHP, file_get_contents($path));
});
