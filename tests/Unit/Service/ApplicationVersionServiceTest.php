<?php
namespace Tests\Unit\Service;

use App\Services\ApplicationVersionService;
use Tests\TestCase;

final class ApplicationVersionServiceTest extends TestCase {

	public function testGetClientVersion(): void {
		$service = new ApplicationVersionService();
		$expected = json_decode(
			file_get_contents(
				base_path('package.json')
			)
		)->version;
		$result = $service->getClientVersion();
		$this->assertSame($expected, $result);
	}

	public function testGetServerVersion(): void {
		$service = new ApplicationVersionService();
		$expected = json_decode(
			file_get_contents(
				base_path('composer.json')
			)
		)->version;
		$result = $service->getServerVersion();
		$this->assertSame($expected, $result);
	}
}
