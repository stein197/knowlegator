<?php
namespace Tests\Feature\Services;

use App\Enum\Http\Method;
use App\Models\EType;
use App\Models\User;
use App\Services\ModelFormService;

test('Action: store', function (): void {
	/** @var \Tests\TestCase $this */
	/** @var \App\Form */
	$form = $this->createApplication()->make(ModelFormService::class)->form(EType::class, 'store');
	$this->assertSame('/en/account/etypes', $form->action);
	$this->assertSame(Method::POST, $form->method);
	$this->assertCount(2, $form->fields);
	$this->assertSame('name', $form->fields[0]->name);
	$this->assertSame('description', $form->fields[1]->name);
	$this->assertCount(2, $form->buttons);
	$this->assertSame('/en/account/etypes', $form->buttons[0]->href);
	$this->assertSame('submit', $form->buttons[1]->type);
});

test('Action: update', function (): void {
	/** @var \Tests\TestCase $this */
	$etype = User::findByEmail('user-1@example.com')->etypes[0];
	/** @var \App\Form */
	$form = $this->createApplication()->make(ModelFormService::class)->form($etype, 'update');
	$this->assertSame("/en/account/etypes/{$etype->id}", $form->action);
	$this->assertSame(Method::PUT, $form->method);
	$this->assertCount(2, $form->fields);
	$this->assertSame('name', $form->fields[0]->name);
	$this->assertSame($etype->name, $form->fields[0]->value);
	$this->assertSame('description', $form->fields[1]->name);
	$this->assertSame($etype->description, $form->fields[1]->value);
	$this->assertCount(2, $form->buttons);
	$this->assertSame("/en/account/etypes/{$etype->id}", $form->buttons[0]->href);
	$this->assertSame('submit', $form->buttons[1]->type);
});

test('Action: destroy', function (): void {
	/** @var \Tests\TestCase $this */
	$etype = User::findByEmail('user-1@example.com')->etypes[0];
	/** @var \App\Form */
	$form = $this->createApplication()->make(ModelFormService::class)->form($etype, 'destroy');
	$this->assertSame("/en/account/etypes/{$etype->id}", $form->action);
	$this->assertSame(Method::DELETE, $form->method);
	$this->assertCount(0, $form->fields);
	$this->assertCount(2, $form->buttons);
	$this->assertSame("/en/account/etypes/{$etype->id}", $form->buttons[0]->href);
	$this->assertSame('submit', $form->buttons[1]->type);
});
