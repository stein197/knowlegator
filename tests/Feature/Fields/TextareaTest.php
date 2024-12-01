<?php
namespace Tests\Feature\Fields;

use App\Fields\TextareaField;

describe('view()', function (): void {
	test('should work', function (): void {
		/** @var \Tests\TestCase $this */
		$f = new TextareaField(
			label: 'Textarea',
			name: 'textarea',
			value: 'Textarea value',
			readonly: true,
			required: false,
			params: ['rows' => 5]
		);
		$dom = $this->dom($f->view()->render());
		$dom->find('//label')->assertTextContent('Textarea');
		$dom->assertExists('//textarea[@name = "textarea" and @value = "textarea value" and @readonly and @rows = "5"]');
	});
});
