<?php
namespace Tests\Feature\Services;

use App\Models\Tag;
use App\Models\User;
use App\Services\ModelRoutingService;

describe('route()', function (): void {

	describe('instance', function (): void {
		test('should return url when the action exists', function (): void {
			/** @var \Tests\TestCase $this */
			$t = User::findByEmail('user-1@example.com')->tags[0];
			$service = $this->createApplication()->make(ModelRoutingService::class);
			$this->assertSame("/en/account/tags/{$t->id}/edit", $service->route($t, 'edit'));
		});

		test('should return null when the action does not exist', function (): void {
			/** @var \Tests\TestCase $this */
			$t = User::findByEmail('user-1@example.com')->tags[0];
			$service = $this->createApplication()->make(ModelRoutingService::class);
			$this->assertNull($service->route($t, 'unknown action'));
		});
	});

	describe('class', function (): void {
		test('should return url when the action exists', function (): void {
			/** @var \Tests\TestCase $this */
			$service = $this->createApplication()->make(ModelRoutingService::class);
			$this->assertSame('/en/account/tags', $service->route(Tag::class, 'index'));
		});
		test('should return null when the action does not exist', function (): void {
			/** @var \Tests\TestCase $this */
			$service = $this->createApplication()->make(ModelRoutingService::class);
			$this->assertNull($service->route(Tag::class, 'unknown action'));
		});
	});
});
