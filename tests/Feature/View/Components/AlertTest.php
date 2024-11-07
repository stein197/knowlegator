<?php
namespace Tests\Feature\View\Components;

use App\View\Components\Alert;

test('should render a message', function (): void {
	/** @var \Tests\TestCase $this */
	$content = (string) $this->component(Alert::class, ['message' => 'yes'])->component->render();
	$this->dom($content)->find('//p/span')->assertTextContent('Yes');
});

test('should render an icon', function (): void {
	/** @var \Tests\TestCase $this */
	$content = (string) $this->component(Alert::class)->component->render();
	$this->dom($content)->assertExists('//i[contains(@class, "bi-exclamation-triangle-fill")]');
});

test('should render specified type', function (): void {
	/** @var \Tests\TestCase $this */
	$content = (string) $this->component(Alert::class, ['type' => 'warning'])->component->render();
	$this->dom($content)->assertExists('//p[contains(@class, "alert-warning")]');
});
