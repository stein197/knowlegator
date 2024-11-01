<?php
namespace Tests\Services\Controllers;

use App\Enum\Theme;
use App\Models\User;
use App\Services\ThemeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

it('/en/settings/theme should redirect to /en/login for guest', function (): void {
	/** @var \Tests\TestCase $this */
	$this->get('/en/settings/theme')->assertRedirect('/en/login');
});

it('/en/settings/theme should show the page', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user)->get('/en/settings/theme')->assertOk();
});

it('should contain theme in <html />', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$this->actingAs($user);
	$content = $this->get('/en/settings/theme')->getContent();
	$this->assertStringContainsString('data-bs-theme=""', $content);
	$this->post('/en/settings/theme', ['theme' => 'dark']);
	$content = $this->get('/en/settings/theme')->getContent();
	$this->assertStringContainsString('data-bs-theme="dark"', $content);
});

it('POST /en/settings/theme should set theme for user', function (): void {
	/** @var \Tests\TestCase $this */
	$user = User::factory()->create();
	$themeService = app(ThemeService::class);
	$this->actingAs($user);
	$this->post('/en/settings/theme', ['theme' => 'dark']);
	$this->assertEquals(Theme::Dark, $themeService->get());
	$this->post('/en/settings/theme', ['theme' => 'light']);
	$this->assertEquals(Theme::Light, $themeService->get());
});
