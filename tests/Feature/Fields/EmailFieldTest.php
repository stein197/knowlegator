<?php
namespace Tests\Feature\Fields;

use App\Fields\EmailField;

describe('view()', function (): void {
	test('should render field', function (): void {
		/** @var \Tests\TestCase $this */
		$f = new EmailField(
			label: 'String',
			name: 'string',
			value: 'string value',
			readonly: true,
			required: false
		);
		$dom = $this->dom($f->view()->render());
		$dom->find('//label')->assertTextContent('String');
		$dom->assertExists('//input[@name = "string" and @value = "string value" and @type = "email" and @readonly]');
	});
});
