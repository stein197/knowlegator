<?php
namespace Tests\Feature\Fields;

use App\Fields\StringField;

describe('view()', function (): void {
	test('should render field', function (): void {
		/** @var \Tests\TestCase $this */
		$f = new StringField(
			label: 'String',
			name: 'string',
			value: 'string value',
			readonly: true,
			required: false
		);
		$dom = $this->dom($f->view()->render());
		$dom->find('//label')->assertTextContent('String');
		$dom->assertExists('//input[@name = "string" and @value = "string value" and @type = "text" and @readonly]');
	});
});
