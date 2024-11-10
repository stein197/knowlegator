<?php
namespace Tests\Feature\Http\Controllers;

use App\Enum\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

describe('GET *', function (): void {
	test('header should contain the form to change the theme', function (): void {
		/** @var \Tests\TestCase $this */
		$content = $this->get('/en/login')->getContent();
		$form = $this->dom($content)->find('//header//form[@action = "/en/theme" and @method = "POST"]');
		$form->assertExists('//input[@name = "_token"]');
		$form->assertExists('//input[@name = "_method" and @value = "PUT"]');
		$form->assertExists('//i[contains(@class, "bi-sun-fill")]');
		$form->assertExists('//i[contains(@class, "bi-sun-fill")]');
		$form->assertExists('//input[contains(@class, "form-check-input")]');
	});
});

describe('PUT /{locale}/theme', function (): void {
	test('should set theme for a user', function (): void {
		/** @var \Tests\TestCase $this */
		$themeService = app('theme');
		$this->actingAs(User::findByEmail('user-1@example.com'));
		$this->put('/en/theme');
		$this->assertEquals(Theme::Dark, $themeService->get());
		$this->put('/en/theme');
		$this->assertEquals(Theme::Light, $themeService->get());
	});
	test('should set theme for a guest', function (): void {
		/** @var \Tests\TestCase $this */
		$themeService = app('theme');
		$this->put('/en/theme');
		$this->assertEquals(Theme::Dark, $themeService->get());
		$this->put('/en/theme');
		$this->assertEquals(Theme::Light, $themeService->get());
	});
});
