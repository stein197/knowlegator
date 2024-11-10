<?php
namespace Tests\Feature;

use App\Models\User;

test('should contain correct links to locales', function (): void {
	/** @var \Tests\TestCase $this */
	$this->markTestSkipped('Request URI is empty for some reason');
	$content = $this->get('/en/login')->getContent();
	$this->assertStringContainsString('href="/en/login', $content);
	$this->assertStringContainsString('href="/de/login', $content);
	$this->assertStringContainsString('href="/ru/login', $content);
	$content = $this->actingAs(User::findByEmail('user-1@example.com'))->get('/en/settings/delete')->getContent();
	$this->assertStringContainsString('href="/en/settings/delete', $content);
	$this->assertStringContainsString('href="/de/settings/delete', $content);
	$this->assertStringContainsString('href="/ru/settings/delete', $content);
});
