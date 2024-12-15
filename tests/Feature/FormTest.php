<?php
namespace Tests\Feature;

use App\Enum\Http\Method;
use App\Fields\CheckboxField;
use App\Fields\EmailField;
use App\Fields\PasswordField;
use App\Fields\StringField;
use App\Fields\TextareaField;
use App\Form;
use App\View\Components\Button;
use Illuminate\Support\Facades\Request;

describe('view()', function (): void {
	test('should contain enctype="multipart/form-data"', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom((new Form())->view()->render());
		$dom->assertExists('//form[@enctype = "multipart/form-data"]');
	});

	test('should render title correctly', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom((new Form(title: 'Form title'))->view()->render());
		$dom->find('//p/strong')->assertTextContent('Form title');
	});

	test('should render action correctly', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom((new Form(action: '/url'))->view()->render());
		$dom->assertExists('//form[@action = "/url"]');
	});

	test('should render method correctly', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom((new Form(method: Method::PUT))->view()->render());
		$dom->assertExists('//form[@method = "POST"]');
		$dom->assertExists('//form/input[@name = "_method" and @value = "PUT"]');
	});

	test('should render fields correctly', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom((new Form(fields: [
			new StringField(
				name: 'text',
				label: 'Text label',
				required: true
			)
		]))->view()->render());
		$dom->assertExists('//input[@name = "text" and @required]');
		$dom->find('//label')->assertTextContent('Text label');
	});

	test('should render <a /> buttons when URL is provided', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom((new Form(buttons: [
			new Button(
				href: '/en'
			)
		]))->view()->render());
		$dom->assertExists('//a[@href = "/en"]');
	});

	test('should render buttons correctly', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom((new Form(buttons: [
			new Button(
				label: 'Button label',
				variant: 'primary',
				name: 'NAME',
				value: 'VALUE',
			)
		]))->view()->render());
		$dom->find('//button[contains(@class, "btn-primary") and @name = "NAME" and @value = "VALUE"]')->assertTextContent('Button label');
	});

	test('should render alert', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom((new Form(alert: [
			'type' => 'success',
			'message' => 'Alert message'
		]))->view()->render());
		$dom->find('//p[contains(@class, "alert-success")]//*')->assertTextContent('Alert message');
	});

	test('should render all fields as readonly when the form is readonly', function (): void {
		/** @var \Tests\TestCase $this */
		$dom = $this->dom((new Form(fields: [
			new StringField(label: 'String', name: 'string'),
			new EmailField(label: 'Email', name: 'email'),
			new PasswordField(label: 'Password', name: 'password'),
			new CheckboxField(label: 'Checkbox', name: 'checkbox'),
			new TextareaField(label: 'Textarea', name: 'textarea')
		], readonly: true))->view()->render());
		$dom->assertExists('//input[@name = "string" and @readonly]');
		$dom->assertExists('//input[@name = "email" and @readonly]');
		$dom->assertExists('//input[@name = "password" and @readonly]');
		$dom->assertExists('//input[@name = "checkbox" and @readonly]');
		$dom->assertExists('//textarea[@name = "textarea" and @readonly]');
	});
});

describe('field()', function (): void {
	test('should return a field with the given name', function (): void {
		/** @var \Tests\TestCase $this */
		$f = new StringField(
			label: 'String',
			name: 'string'
		);
		$form = new Form(fields: [$f]);
		$this->assertSame($f, $form->field('string'));
	});

	test('should retunn null when the field with the given name doesn\'t exist', function (): void {
		/** @var \Tests\TestCase $this */
		$form = new Form(fields: []);
		$this->assertNull($form->field('string'));
	});
});

describe('toArray()', function (): void {
	test('should return an empty array when there are no fields', function (): void {
		/** @var \Tests\TestCase $this */
		$form = new Form();
		$this->assertSame([], $form->toArray());
	});

	test('should return an associative array', function (): void {
		/** @var \Tests\TestCase $this */
		$form = new Form(fields: [
			new StringField(
				label: 'String',
				name: 'string',
				value: 'string value'
			)
		]);
		$this->assertSame(['string' => 'string value'], $form->toArray());
	});
});

describe('applyRequest()', function (): void {
	test('should apply values to fields from request', function (): void {
		/** @var \Tests\TestCase $this */
		$form = new Form(fields: [
			new StringField(
				name: 'text',
				label: 'Text label',
				required: true
			)
		]);
		$request = Request::create('/url', 'GET', ['text' => 'some value']);
		$form->applyRequest($request);
		$this->assertSame('some value', $form->field('text')->value);
	});

	test('should abort request when the validation doesn\'t pass', function (): void {
		/** @var \Tests\TestCase $this */
		$this->markTestSkipped();
	});
});
