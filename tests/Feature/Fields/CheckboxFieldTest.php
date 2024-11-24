<?php
namespace Tests\Feature\Fields;

use App\Fields\CheckboxField;

describe('view()', function (): void {
	test('should render field', function (): void {
		/** @var \Tests\TestCase $this */
		$f = new CheckboxField(
			label: 'Check',
			name: 'check',
			params: ['checked' => true]
		);
		$dom = $this->dom($f->view()->render());
		$dom->assertExists('//input[@name = "check" and @type = "checkbox" and @checked]');
	});
});
