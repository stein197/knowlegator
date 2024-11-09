<?php
namespace Tests\Feature\View\Components;

use App\Enum\FormFieldType;
use App\Records\ButtonRecord;
use App\Records\FormFieldRecord;
use App\View\Components\Form;

test('should containt enctype="multipart/form-data"', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class);
	$view->assertSee('enctype="multipart/form-data"', false);
});

test('should render title correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['title' => 'Form title']);
	$view->assertSee('<strong>Form title</strong>', false);
});

test('should render an empty form when there are no input', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class);
	$view->assertSee('action=""', false);
	$view->assertSee('method="POST"', false);
});

test('should render action correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['action' => '/url']);
	$view->assertSee('action="/url"', false);
});

test('should render method correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['method' => 'PUT']);
	$view->assertSee('type="hidden" name="_method" value="PUT"', false);
});

test('should render fields correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['fields' => [
		new FormFieldRecord(
			name: 'text',
			label: 'Text label',
			type: FormFieldType::Text,
			required: true
		)
	]]);
	$view->assertSee('Text label', false);
	$view->assertSee('type="text"', false);
	$view->assertSee('required', false);
});

test('should render default input values', function (): void {
	/** @var \Tests\TestCase $this */
	$this->dom((string) $this->component(Form::class, [
		'fields' => [
			new FormFieldRecord(
				name: 'text',
				value: 'custom value'
			)
		]
	])->component->render())->assertExists('//input[@name = "text" and @value = "custom value"]');
});

test('should render checkboxes', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['fields' => [
		new FormFieldRecord(
			name: 'checkbox',
			label: 'Checkbox label',
			type: FormFieldType::Checkbox,
			required: true
		)
	]]);
	$view->assertSee('Checkbox label', false);
	$view->assertSee('type="checkbox"', false);
	$view->assertSee('class="form-check-input"', false);
});

test('should render buttons correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['buttons' => [
		new ButtonRecord(
			label: 'Button label',
			type: 'primary',
			name: 'NAME',
			value: 'VALUE',
		)
	]]);
	$view->assertSee('Button label', false);
	$view->assertSee('btn-primary', false);
	$view->assertSee('name="NAME"', false);
	$view->assertSee('value="VALUE"', false);
});
