<?php
namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\ModelRoutingService;

describe('route()', function (): void {
	test('should return url when the action exists', function (): void {
		/** @var \Tests\TestCase $this */
		$t = User::findByEmail('user-1@example.com')->tags[0];
		$service = $this->createApplication()->make(ModelRoutingService::class);
		$this->assertSame("/en/account/tags/{$t->id}/edit", $service->route($t, 'edit'));
	});

	test('should return null when the action does not exist', function (): void {
		/** @var \Tests\TestCase */
		$t = User::findByEmail('user-1@example.com')->tags[0];
		$service = $this->createApplication()->make(ModelRoutingService::class);
		$this->assertNull($service->route($t, 'unknown action'));
	});
});
