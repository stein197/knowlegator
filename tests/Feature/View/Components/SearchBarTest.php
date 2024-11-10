<?php
namespace Tests\Feature\View\Components;

use App\View\Components\SearchBar;

test('should render search bar with the given parameters', function (): void {
	/** @var \Tests\TestCase $this */
	$component = $this->domComponent(SearchBar::class, [
		'action' => '/en/search',
		'placeholder' => 'Placeholder',
		'value' => 'value'
	]);
	$form = $component->find('//form[@action = "/en/search" and @method = "GET"]');
	$form->assertExists('//button/i[contains(@class, "bi-search")]');
	$form->assertExists('//input[@placeholder = "Placeholder" and @value = "value" and @name = "q"]');
});
