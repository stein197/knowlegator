<?php
namespace Tests\Feature\View\Components;

use App\View\Components\Button;

test('default', function (): void {
	/** @var \Tests\TestCase $this */
	$this->domComponent(Button::class)->assertExists('//button[@type = "button" and contains(@class, "btn")]');
});

test('<a /> when $href is privided', function (): void {
	/** @var \Tests\TestCase $this */
	$this->domComponent(Button::class, [
		'label' => 'Button',
		'variant' => 'danger',
		'class' => 'custom-class',
		'name' => 'key',
		'value' => 'value',
		'href' => '/en/login'
	])->find('//a[contains(@class, "btn-danger") and contains(@class, "custom-class") and @href = "/en/login"]')->assertTextContent('Button');
	$this->domComponent(Button::class, [
		'label' => 'Button',
		'variant' => 'danger',
		'class' => 'custom-class',
		'name' => 'key',
		'value' => 'value',
		'href' => '/en/login',
		'icon' => 'plus',
		'iconClass' => 'custom-icon'
	])->assertExists('//a[contains(@class, "btn-danger") and contains(@class, "custom-class") and @href = "/en/login" and @data-bs-toggle = "tooltip" and @data-bs-title = "Button"]//i[@class = "bi bi-plus custom-icon"]');
});

test('<button /> when $href is not provided', function (): void {
	/** @var \Tests\TestCase $this */
	/** @var \Tests\TestCase $this */
	$this->domComponent(Button::class, [
		'label' => 'Button',
		'variant' => 'danger',
		'class' => 'custom-class',
		'name' => 'key',
		'value' => 'value'
	])->find('//button[contains(@class, "btn-danger") and contains(@class, "custom-class") and @name = "key" and @value = "value" and @type = "button"]')->assertTextContent('Button');
	$this->domComponent(Button::class, [
		'label' => 'Button',
		'variant' => 'danger',
		'type' => 'submit',
		'class' => 'custom-class',
		'name' => 'key',
		'value' => 'value',
		'icon' => 'plus',
		'iconClass' => 'custom-icon'
	])->assertExists('//button[contains(@class, "btn-danger") and contains(@class, "custom-class") and @name = "key" and @value = "value" and @type = "submit"]/i[@class = "bi bi-plus custom-icon"]');
});
