<?php
namespace Tests\Feature\View\Components;

use App\View\Components\Form;

it('should containt enctype="multipart/form-data"', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class);
	$view->assertSee('enctype="multipart/form-data"', false);
});

it('should render title correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['title' => 'Form title']);
	$view->assertSee('<strong>Form title</strong>', false);
});

it('should render an empty form when there are no input', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class);
	$view->assertSee('action=""', false);
	$view->assertSee('method="POST"', false);
});

it('should render action correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['action' => '/url']);
	$view->assertSee('action="/url"', false);
});

it('should render method correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['method' => 'PUT']);
	$view->assertSee('type="hidden" name="_method" value="PUT"', false);
});

it('should render fields correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['fields' => [
		'text' => [
			'label' => 'Text label',
			'type' => 'text',
			'required' => true
		]
	]]);
	$view->assertSee('Text label', false);
	$view->assertSee('type="text"', false);
	$view->assertSee('required', false);
});

it('should render checkboxes', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['fields' => [
		'checkbox' => [
			'label' => 'Checkbox label',
			'type' => 'checkbox',
			'required' => true
		]
	]]);
	$view->assertSee('Checkbox label', false);
	$view->assertSee('type="checkbox"', false);
	$view->assertSee('class="form-check-input"', false);
});

it('should render buttons correctly', function (): void {
	/** @var \Tests\TestCase $this */
	$view = $this->component(Form::class, ['buttons' => [
		[
			'label' => 'Button label',
			'type' => 'primary',
			'name' => 'NAME',
			'value' => 'VALUE',
		]
	]]);
	$view->assertSee('Button label', false);
	$view->assertSee('btn-primary', false);
	$view->assertSee('name="NAME"', false);
	$view->assertSee('value="VALUE"', false);
});
