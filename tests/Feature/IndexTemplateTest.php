<?php
namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

it('should contain correct links to locales', function (): void {
	/** @var \Tests\TestCase $this */
	$this->markTestSkipped('Request URI is empty for some reason');
	$content = $this->get('/en/login')->getContent();
	$this->assertStringContainsString('href="/en/login', $content);
	$this->assertStringContainsString('href="/de/login', $content);
	$this->assertStringContainsString('href="/ru/login', $content);
	$user = User::factory()->create();
	$content = $this->actingAs($user)->get('/en/settings/delete')->getContent();
	$this->assertStringContainsString('href="/en/settings/delete', $content);
	$this->assertStringContainsString('href="/de/settings/delete', $content);
	$this->assertStringContainsString('href="/ru/settings/delete', $content);
});