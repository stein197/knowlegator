<?php
namespace Tests\Feature\View\Components;

use App\View\Components\Alert;

test('should render a message', function (): void {
	/** @var \Tests\TestCase $this */
	$dom = $this->dom((string) $this->blade('<x-alert>Yes</x-alert>'));
	$dom->find('//p/span')->assertTextContent('Yes');
});

test('should render passed icon', function (): void {
	/** @var \Tests\TestCase $this */
	$content = (string) $this->component(Alert::class, ['icon' => 'exclamation-triangle-fill'])->component->render();
	$this->dom($content)->assertExists('//i[contains(@class, "bi-exclamation-triangle-fill")]');
});

test('should not render icon when it\'s not passed', function (): void {
	/** @var \Tests\TestCase $this */
	$this->domComponent(Alert::class)->assertNotExists('//i');
});

test('should render specified type', function (): void {
	/** @var \Tests\TestCase $this */
	$content = (string) $this->component(Alert::class, ['type' => 'warning'])->component->render();
	$this->dom($content)->assertExists('//p[contains(@class, "alert-warning")]');
});
