<?php
namespace Tests\Feature\View\Components;

use App\View\Components\Alert;

test('should render a message', function (): void {
	/** @var \Tests\TestCase $this */
	$content = (string) $this->component(Alert::class, ['message' => 'yes'])->component->render();
	$this->dom($content)->find('//p/span')->assertTextContent('Yes');
});

test('should render an exclamation-triangle-fill icon', function (): void {
	/** @var \Tests\TestCase $this */
	$content = (string) $this->component(Alert::class)->component->render();
	$this->dom($content)->assertExists('//i[contains(@class, "bi-exclamation-triangle-fill")]');
});

test('should not render an icon if it was not explicitly defined', function (): void {
	/** @var \Tests\TestCase $this */
	$this->domComponent(Alert::class, ['icon' => null])->assertNotExists('//i');
});

test('should render specified type', function (): void {
	/** @var \Tests\TestCase $this */
	$content = (string) $this->component(Alert::class, ['type' => 'warning'])->component->render();
	$this->dom($content)->assertExists('//p[contains(@class, "alert-warning")]');
});
