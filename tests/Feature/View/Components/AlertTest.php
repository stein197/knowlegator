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

test('should render custom CSS class', function (): void {
	/** @var \Tests\TestCase $this */
	$this->domComponent(Alert::class, ['class' => 'text-center'])->assertExists('//p[contains(@class, "text-center")]');
});

test('should have the \'callout\' css-class when the \'callout\' parameter is provided', function (): void {
	/** @var \Tests\TestCase */
	$this->domComponent(Alert::class, ['callout' => true])->assertExists('//p[contains(@class, "callout")]');
});

test('should be dismissible when dismissible is true', function (): void {
	/** @var \Tests\TestCase $this */
	$this->domComponent(Alert::class, ['dismissible' => true])->assertExists('//p[contains(@class, "alert-dismissible")]//button[@data-bs-dismiss="alert"]');
});
