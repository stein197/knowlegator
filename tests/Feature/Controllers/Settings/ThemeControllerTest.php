<?php
namespace Tests\Services\Controllers;

use App\Enum\Theme;
use App\Models\User;
use App\Services\ThemeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('GET /{locale}/settings/theme', function (): void {
	test('should redirect to /{locale}/login for guests', function (): void {
		/** @var \Tests\TestCase $this */
		$this->get('/en/settings/theme')->assertRedirect('/en/login');
	});
	
	test('should show page for users', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$this->actingAs($user)->get('/en/settings/theme')->assertOk();
	});

	test('should contain theme in <html />', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$this->actingAs($user);
		$content = $this->get('/en/settings/theme')->getContent();
		$this->dom($content)->assertExists('/*[@data-bs-theme=""]');
		$this->post('/en/settings/theme', ['theme' => 'dark']);
		$content = $this->get('/en/settings/theme')->getContent();
		$this->dom($content)->assertExists('/*[@data-bs-theme="dark"]');
	});
});

describe('POST /{locale}/settings/theme', function (): void {
	test('should set theme for user', function (): void {
		/** @var \Tests\TestCase $this */
		$user = User::factory()->create();
		$themeService = app(ThemeService::class);
		$this->actingAs($user);
		$this->post('/en/settings/theme', ['theme' => 'dark']);
		$this->assertEquals(Theme::Dark, $themeService->get());
		$this->post('/en/settings/theme', ['theme' => 'light']);
		$this->assertEquals(Theme::Light, $themeService->get());
	});
});
